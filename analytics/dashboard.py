"""Aggregate anonymous registration counts and emit Plotly figure JSON.

Python 3.10+, standard library only. Input: JSON on stdin. Output: JSON on stdout.
Revenue uses confirmed receipt amounts grouped by receipt date; prices never determine revenue.
"""

import html
import json
import math
import sys
from collections import Counter
from datetime import date, timedelta


PAYMENTS = {
    "disetujui": ("Disetujui", "#059669"),
    "menunggu_pembayaran": ("Menunggu pembayaran", "#a89ba1"),
    "menunggu_verifikasi": ("Menunggu verifikasi", "#f59e0b"),
    "ditolak": ("Ditolak", "#dc2626"),
    "unknown": ("Belum diklasifikasi", "#a76679"),
}

PARTICIPANTS = {
    "menunggu_pembayaran": ("Menunggu pembayaran", "#a89ba1"),
    "menunggu_verifikasi": ("Menunggu verifikasi", "#f59e0b"),
    "diproses": ("Diproses", "#a76679"),
    "diterima": ("Diterima", "#059669"),
    "ditolak": ("Ditolak", "#dc2626"),
    "unknown": ("Belum diklasifikasi", "#7b6e76"),
}


def figure(traces, empty=False, **layout):
    base = {
        "separators": ",.",
        "paper_bgcolor": "rgba(0,0,0,0)", "plot_bgcolor": "rgba(0,0,0,0)",
        "font": {"family": "Inter, Arial, sans-serif", "color": "#68717f", "size": 11},
        "margin": {"l": 60, "r": 20, "t": 20, "b": 55},
        "xaxis": {"gridcolor": "#f5eff1", "zeroline": False, "automargin": True},
        "yaxis": {"gridcolor": "#f5eff1", "zeroline": False, "rangemode": "tozero", "automargin": True},
        "legend": {"orientation": "h", "y": -0.25, "x": 0},
        "hoverlabel": {"bgcolor": "#fff", "bordercolor": "#e8dce0", "align": "left",
                       "font": {"color": "#49323b", "size": 13}},
    }
    base.update(layout)
    if empty:
        traces = []
        base.update({
            "annotations": [{"text": "Belum ada data untuk filter ini", "showarrow": False,
                             "xref": "paper", "yref": "paper", "x": 0.5, "y": 0.5}],
            "xaxis": {"visible": False}, "yaxis": {"visible": False}, "shapes": [],
        })
    return {"data": traces, "layout": base}


MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']


def date_label(value):
    day = date.fromisoformat(value)
    return f'{day.day} {MONTHS[day.month - 1]} {day.year}'


def amount_label(value):
    unit, divisor = (' miliar', 1000000000) if value >= 1000000000 else (
        (' juta', 1000000) if value >= 1000000 else ((' ribu', 1000) if value >= 1000 else ('', 1)))
    return 'Rp ' + f'{value / divisor:.1f}'.rstrip('0').rstrip('.').replace('.', ',') + unit


def count_label(value):
    return f'{value:,}'.replace(',', '.')


def comparison_layout(ids, labels, values, shares, maximum):
    annotations = []
    for index, (label, value, share) in enumerate(zip(labels, values, shares)):
        common = {'xref': 'paper', 'yref': 'y', 'y': index, 'yshift': 19, 'yanchor': 'bottom', 'showarrow': False}
        annotations.extend([
            dict(common, x=0, xanchor='left', align='left', text=html.escape(label),
                 font={'size': 13, 'color': '#46353d'}),
            dict(common, x=1, xanchor='right', align='right',
                 text=f'<b>{count_label(value)}</b> · ' + f'{share:g}'.replace('.', ',') + '%',
                 font={'size': 13, 'color': '#823749'}),
        ])
    return {
        'showlegend': False, 'dragmode': False,
        'margin': {'l': 24, 'r': 24, 't': 8, 'b': 12},
        'annotations': annotations,
        'shapes': [{'type': 'line', 'xref': 'paper', 'yref': 'y', 'x0': 0, 'x1': 1,
                    'y0': index, 'y1': index, 'line': {'color': '#f5eef0', 'width': 12}, 'layer': 'below'} for index in range(len(ids))],
        'yaxis': {'type': 'category', 'categoryorder': 'array', 'categoryarray': ids,
                  'range': [len(ids) - 0.5, -0.95], 'showticklabels': False, 'showgrid': False,
                  'zeroline': False, 'fixedrange': True},
        'xaxis': {'range': [0, max(maximum, 1)], 'showticklabels': False, 'showgrid': False,
                  'zeroline': False, 'fixedrange': True},
    }


def revenue_chart(periods, interval, has_data):
    keys = [p['period'] for p in periods]
    values = [p['actual_revenue'] for p in periods]
    labels = [f"{MONTHS[int(p['period'][5:7]) - 1]} {p['period'][:4]}" if interval == 'month'
              else date_label(p['start_date']) for p in periods]
    step = max(1, (len(keys) + 5) // 6)
    tick_indices = sorted(set(range(0, len(keys), step)) | {len(keys) - 1})
    max_value = max(values, default=0)
    magnitude = 10 ** math.floor(math.log10(max_value / 4)) if max_value else 1
    tick_step = next(step * magnitude for step in [1, 2, 2.5, 5, 10] if step * magnitude >= max_value / 4)
    ceiling = math.ceil(max_value / tick_step) * tick_step if max_value else 1
    ticks = [i * tick_step for i in range(math.ceil(max_value / tick_step) + 1)] if max_value else [0]
    trace = {
        'type': 'scatter', 'mode': 'lines+markers', 'name': 'Pemasukan tercatat', 'x': keys, 'y': values,
        'line': {'color': '#ad263b', 'width': 3}, 'fill': 'tozeroy', 'fillcolor': 'rgba(173,38,59,0.045)',
        'marker': {'color': '#ad263b', 'size': 7, 'line': {'color': '#fff', 'width': 2}},
        'text': [],
        'textposition': 'top center', 'textfont': {'size': 12, 'color': '#5b3944'}, 'cliponaxis': False,
        'customdata': [[date_label(p['start_date']) + ' – ' + date_label(p['end_date']), p['receipt_count']] for p in periods],
        'hovertemplate': '%{customdata[0]}<br>Pemasukan: Rp %{y:,.0f}<br>%{customdata[1]:,.0f} pembayaran tercatat<extra></extra>',
    }
    return figure([trace], empty=not has_data, showlegend=False, hovermode='closest',
                  margin={'l': 85, 'r': 25, 't': 25, 'b': 45},
                  xaxis={'type': 'category', 'range': [-0.35, max(0.65, len(keys) - 0.65)], 'tickvals': [keys[i] for i in tick_indices],
                         'ticktext': [labels[i] for i in tick_indices],
                         'automargin': True, 'fixedrange': False, 'showgrid': False, 'zeroline': False,
                         'tickfont': {'color': '#788291', 'size': 11}},
                  yaxis={'tickvals': ticks, 'ticktext': [amount_label(v) for v in ticks],
                         'range': [0, max(ceiling, max_value * 1.08)], 'gridcolor': '#edf0f4',
                         'griddash': 'dot', 'zeroline': False, 'fixedrange': True})


def ranking(programs):
    selected = sorted((p for p in programs if p['registrations'] > 0 and p['capacity'] > 0),
                      key=lambda p: (-p['registrations'] / p['capacity'], -p['registrations'], p['title'], p['id']))[:5]
    ids = [str(p['id']) for p in selected]
    values = [p['registrations'] for p in selected]
    rates = [p['registrations'] / p['capacity'] * 100 for p in selected]
    layout = comparison_layout(ids, [p['title'] for p in selected], values, rates, max(100, max(rates, default=0)))
    for index, p in enumerate(selected):
        rate = f"{rates[index]:.1f}".rstrip('0').rstrip('.').replace('.', ',')
        layout['annotations'][index * 2 + 1]['text'] = f"<b>{count_label(p['registrations'])} / {count_label(p['capacity'])}</b> · {rate}%"
    for shape in layout['shapes']:
        shape.update(xref='x', x1=100)
    layout['shapes'].append({'type': 'line', 'xref': 'x', 'yref': 'paper', 'x0': 100, 'x1': 100,
                             'y0': 0, 'y1': 1, 'line': {'color': '#cbb5bd', 'width': 1, 'dash': 'dot'}, 'layer': 'above'})
    layout['margin']['b'] = 50
    maximum = max(100, max(rates, default=0))
    ticks = [0, 25, 50, 75, 100] + ([round(maximum, 1)] if maximum >= 125 else [])
    layout['xaxis'].update(showticklabels=True, tickvals=ticks, ticktext=[f'{v:g}%'.replace('.', ',') for v in ticks],
                          range=[0, maximum * 1.04],
                          title={'text': 'Pendaftar dibanding kapasitas program', 'standoff': 12})
    trace = {
        'type': 'bar', 'orientation': 'h', 'x': rates, 'y': ids,
        'marker': {'color': ['#b92236', '#cb5365', '#d47786', '#dea0aa', '#e8bdc5'][:len(ids)], 'cornerradius': 6},
        'width': 0.18,
        'customdata': [[p['id'], html.escape(p['title']), p['registrations'], p['capacity'], round(rate, 1)] for p, rate in zip(selected, rates)],
        'hovertemplate': '%{customdata[1]}<br>%{customdata[2]:,.0f} pendaftar / %{customdata[3]:,.0f} kapasitas<br>Keterisian: %{customdata[4]}%<extra></extra>',
    }
    chart = figure([trace], empty=not selected, **layout)
    if not selected and any(p['registrations'] for p in programs):
        chart['layout']['annotations'][0]['text'] = 'Kapasitas program belum ditentukan'
    return chart


def calculate(payload):
    filters = payload["filters"]
    start, end = date.fromisoformat(filters["start_date"]), date.fromisoformat(filters["end_date"])
    monthly = filters["interval"] == "month"
    weekly = filters["interval"] == "week"
    keys = []
    cursor = start.replace(day=1) if monthly else (start - timedelta(days=start.weekday()) if weekly else start)
    while cursor <= end:
        keys.append(cursor.isoformat()[:7] if monthly else cursor.isoformat())
        cursor = (date(cursor.year + (cursor.month == 12), cursor.month % 12 + 1, 1)
                  if monthly else cursor + timedelta(days=7 if weekly else 1))
    programs = {}
    for source in payload["programs"]:
        p = dict(source)
        capacity = max(0, int(p["total_quota"]))
        remaining = min(capacity, max(0, int(p["quota"])))
        p.update(registrations=0, approved=0, actual_revenue=0, receipt_count=0, missing_receipts=0,
                 capacity=capacity, remaining=remaining, occupied=capacity - remaining,
                 payments=Counter(), participants=Counter())
        programs[int(p["id"])] = p
    counts, revenue, payments, participants = Counter(), Counter(), Counter(), Counter()
    approved_by_date, pending_by_date, receipts_by_date = Counter(), Counter(), Counter()
    for row in payload["registrations"]:
        registered_on = date.fromisoformat(row["registration_date"])
        if not start <= registered_on <= end or int(row["program_id"]) not in programs:
            continue
        p = programs[int(row["program_id"])]
        count = int(row["total"])
        key = (registered_on.isoformat()[:7] if monthly else
               (registered_on - timedelta(days=registered_on.weekday())).isoformat() if weekly else registered_on.isoformat())
        status = row["payment_status"] if row["payment_status"] in PAYMENTS else "unknown"
        participant = row.get("participant_status", "unknown")
        participant = participant if participant in PARTICIPANTS else "unknown"
        counts[key] += count
        payments[status] += count
        p["registrations"] += count
        p["payments"][status] += count
        p["participants"][participant] += count
        participants[participant] += count
        if status in ["menunggu_pembayaran", "menunggu_verifikasi"]:
            pending_by_date[key] += count
        if status == "disetujui":
            approved_by_date[key] += count
            p["approved"] += count
    legacy_dates = 0
    for receipt in payload.get('receipts', []):
        received_on = date.fromisoformat(receipt['received_date'])
        if not start <= received_on <= end or int(receipt['program_id']) not in programs:
            continue
        p = programs[int(receipt['program_id'])]
        key = (received_on.isoformat()[:7] if monthly else
               (received_on - timedelta(days=received_on.weekday())).isoformat() if weekly else received_on.isoformat())
        amount, count = int(receipt['amount']), int(receipt['total'])
        p['actual_revenue'] += amount
        p['receipt_count'] += count
        revenue[key] += amount
        receipts_by_date[key] += count
        legacy_dates += int(receipt.get('legacy_dates', 0))
    for missing in payload.get('missing_receipts', []):
        if int(missing['program_id']) in programs:
            programs[int(missing['program_id'])]['missing_receipts'] = int(missing['total'])
    receipt_count = sum(receipts_by_date.values())
    missing_count = sum(p['missing_receipts'] for p in programs.values())
    rows = sorted(programs.values(), key=lambda p: (-p["registrations"], p["title"], p["id"]))
    total, approved = sum(counts.values()), payments["disetujui"]
    for p in rows:
        p["popularity_rate"] = round(p["registrations"] / p["capacity"] * 100, 1) if p["capacity"] else None
        p["approval_rate"] = round(p["approved"] / p["registrations"] * 100, 1) if p["registrations"] else None
    capacity, occupied = sum(p["capacity"] for p in rows), sum(p["occupied"] for p in rows)
    periods = [{"period": k, "start_date": max(start, date.fromisoformat(k + "-01" if monthly else k)).isoformat(),
                     "end_date": min(end, (date(int(k[:4]) + (int(k[5:7]) == 12), int(k[5:7]) % 12 + 1, 1) - timedelta(days=1))
                                      if monthly else date.fromisoformat(k) + timedelta(days=6 if weekly else 0)).isoformat(),
                     "registrations": counts[k], "approved": approved_by_date[k], "pending": pending_by_date[k],
                     "actual_revenue": revenue[k], "receipt_count": receipts_by_date[k]} for k in keys]
    charts = {
        'revenue_trend': revenue_chart(periods, filters['interval'], bool(receipt_count)),
        'popular_programs': ranking(rows),
    }
    return {
        "filters": filters,
        "summary": {"registrations": total, "approved": approved,
                    "actual_revenue": sum(revenue.values()) if receipt_count or not missing_count else None,
                    "receipt_count": receipt_count, "missing_receipts": missing_count,
                    "legacy_receipt_dates": legacy_dates,
                    "accepted_rate": round(participants['diterima'] / total * 100, 1) if total else None,
                    "high_demand_programs": sum(1 for p in rows if p['capacity'] and p['registrations'] / p['capacity'] >= 0.8),
                    "approval_rate": round(approved / total * 100, 1) if total else None,
                    "pending": payments["menunggu_pembayaran"] + payments["menunggu_verifikasi"],
                    "accepted": participants["diterima"],
                    "occupied": occupied, "capacity": capacity,
                    "occupancy_rate": round(occupied / capacity * 100, 1) if capacity else None},
        "charts": charts,
        "programs": [{k: p[k] for k in ["id", "title", "category", "price", "registrations", "approved",
                                        "actual_revenue", "capacity", "occupied", "remaining", "payments", "participants", "approval_rate", "popularity_rate", "receipt_count", "missing_receipts"]}
                     for p in rows if p["registrations"] or p["receipt_count"] or p["missing_receipts"]],
        "snapshot": {"capacity": capacity, "occupied": occupied, "remaining": capacity - occupied,
                     "programs": [{k: p[k] for k in ["id", "title", "capacity", "occupied", "remaining"]} for p in rows]},
        "payment_breakdown": [{"status": s, "label": PAYMENTS[s][0], "count": payments[s],
                               "percentage": round(payments[s] / total * 100, 1) if total else None} for s in PAYMENTS],
        "participant_breakdown": [{"status": s, "label": PARTICIPANTS[s][0], "count": participants[s]} for s in PARTICIPANTS],
        "periods": periods,
        "empty": total == 0 and receipt_count == 0,
    }


if __name__ == "__main__":
    json.dump(calculate(json.load(sys.stdin)), sys.stdout, ensure_ascii=True, allow_nan=False)
