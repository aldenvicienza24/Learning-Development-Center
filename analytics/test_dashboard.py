import unittest

from dashboard import calculate


class DashboardTest(unittest.TestCase):
    def test_duplicate_titles_unknown_status_and_free_programs(self):
        payload = {
            "filters": {"start_date": "2026-01-01", "end_date": "2026-01-03", "interval": "day"},
            "programs": [
                {"id": 1, "title": "<b>Same</b>", "category": "sertifikasi", "price": 0, "total_quota": 0, "quota": 0},
                {"id": 2, "title": "<b>Same</b>", "category": "sertifikasi", "price": 100, "total_quota": 5, "quota": 3},
            ],
            "registrations": [
                {"program_id": 1, "registration_date": "2026-01-01", "payment_status": "disetujui", "total": 2},
                {"program_id": 2, "registration_date": "2026-01-03", "payment_status": "ditolak", "total": 3},
                {"program_id": 2, "registration_date": "2026-01-03", "payment_status": "legacy", "total": 1},
            ],
        }
        payload["receipts"] = [{"program_id": 1, "received_date": "2026-01-01", "amount": 0, "total": 2}]
        result = calculate(payload)
        self.assertEqual(result["summary"]["registrations"], 6)
        self.assertEqual(result["summary"]["approved"], 2)
        self.assertEqual(result["summary"]["actual_revenue"], 0)
        self.assertEqual([p["registrations"] for p in result["periods"]], [2, 0, 4])
        bars = result["charts"]["popular_programs"]["data"][0]
        self.assertEqual(bars["y"], ["2"])
        self.assertEqual(bars["customdata"][0][1], "&lt;b&gt;Same&lt;/b&gt;")
        self.assertEqual(next(row['count'] for row in result['payment_breakdown'] if row['status'] == 'unknown'), 1)
        self.assertEqual(result["charts"]["revenue_trend"]["data"][0]["y"], [0, 0, 0])
        self.assertEqual(sum(p["registrations"] for p in result["periods"]), 6)

    def test_partial_weeks_and_leap_month_reconcile(self):
        payload = {"filters": {"start_date": "2024-02-28", "end_date": "2024-03-05", "interval": "week"},
                   "programs": [{"id": 1, "title": "Test", "category": "sertifikasi", "price": 100, "total_quota": 10, "quota": 8}],
                   "registrations": [{"program_id": 1, "registration_date": "2024-02-29", "payment_status": "disetujui", "participant_status": "diterima", "total": 2},
                                     {"program_id": 1, "registration_date": "2024-03-04", "payment_status": "menunggu_verifikasi", "participant_status": "diproses", "total": 3}]}
        result = calculate(payload)
        self.assertEqual([(p["start_date"], p["end_date"]) for p in result["periods"]],
                         [("2024-02-28", "2024-03-03"), ("2024-03-04", "2024-03-05")])
        self.assertEqual([p["registrations"] for p in result["periods"]], [2, 3])
        self.assertEqual(result["summary"]["pending"], 3)
        payload["filters"]["interval"] = "month"
        result = calculate(payload)
        self.assertEqual(result["periods"][0]["end_date"], "2024-02-29")
        self.assertEqual(result["periods"][1]["start_date"], "2024-03-01")

    def test_no_programs_does_not_invent_rates(self):
        result = calculate({"filters": {"start_date": "2026-01-01", "end_date": "2026-03-01", "interval": "month"},
                            "programs": [], "registrations": []})
        self.assertIsNone(result["summary"]["occupancy_rate"])
        self.assertIsNone(result["summary"]["approval_rate"])
        self.assertTrue(result["empty"])
        self.assertTrue(all(not chart["data"] for chart in result["charts"].values()))

    def test_core_charts_reconcile_and_top_five_uses_program_capacity(self):
        result = calculate({
            "filters": {"start_date": "2026-04-13", "end_date": "2026-05-02", "interval": "month"},
            "programs": [{"id": i, "title": f"Program {i}", "category": "sertifikasi", "price": 100000,
                          "total_quota": 20, "quota": 10} for i in range(1, 7)],
            "registrations": [{"program_id": i, "registration_date": "2026-04-15",
                               "payment_status": "disetujui", "total": i} for i in range(1, 7)],
            "receipts": [{"program_id": i, "received_date": "2026-04-15", "amount": i * 80000, "total": i} for i in range(1, 7)],
        })
        self.assertEqual(set(result["charts"]), {"revenue_trend", "popular_programs"})
        revenue = result["charts"]["revenue_trend"]["data"][0]
        self.assertEqual(sum(revenue["y"]), result["summary"]["actual_revenue"])
        self.assertEqual(revenue["customdata"][0], ["13 Apr 2026 – 30 Apr 2026", 21])
        self.assertEqual(revenue["customdata"][1], ["1 Mei 2026 – 2 Mei 2026", 0])
        ranking = result["charts"]["popular_programs"]["data"][0]
        self.assertEqual(ranking["x"], [30, 25, 20, 15, 10])
        self.assertEqual(ranking["customdata"][0][2:], [6, 20, 30.0])
        self.assertEqual(revenue['type'], 'scatter')

    def test_popularity_ranks_by_capacity_and_keeps_over_capacity_visible(self):
        payload = {
            'filters': {'start_date': '2026-01-01', 'end_date': '2026-02-28', 'interval': 'month'},
            'programs': [{'id': i, 'title': f'Program {i}', 'category': 'sertifikasi', 'price': 100,
                          'total_quota': capacity, 'quota': capacity} for i, capacity in [(1, 100), (2, 10), (3, 10), (4, 0)]],
            'registrations': [{'program_id': i, 'registration_date': '2026-01-15', 'payment_status': 'disetujui',
                               'total': count} for i, count in [(1, 80), (2, 9), (3, 12), (4, 100)]],
        }
        result = calculate(payload)
        chart = result['charts']['popular_programs']
        self.assertEqual(chart['data'][0]['y'], ['3', '2', '1'])
        self.assertEqual(chart['data'][0]['x'], [120, 90, 80])
        self.assertGreaterEqual(chart['layout']['xaxis']['range'][1], 120)
        self.assertIsNone(next(p['popularity_rate'] for p in result['programs'] if p['id'] == 4))
        self.assertEqual(result['summary']['occupied'], 0)  # Current quota is separate from filtered registrations.
        payload['filters']['start_date'] = '2026-02-01'
        result = calculate(payload)
        self.assertEqual(result['charts']['popular_programs']['data'], [])
        self.assertEqual(result['summary']['actual_revenue'], 0)


if __name__ == "__main__":
    unittest.main()
