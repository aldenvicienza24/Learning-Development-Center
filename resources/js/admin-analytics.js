import Plotly from 'plotly.js-basic-dist';
import '../css/admin-analytics.css';

const root = document.getElementById('analytics-dashboard');
if (root) {
    const rootStyles = getComputedStyle(root);
    const themeColor = (name, fallback) => rootStyles.getPropertyValue(name).trim() || fallback;
    const palette = {
        brand: themeColor('--uisi-blue', '#1D4ED8'),
        accent: themeColor('--uisi-cobalt', '#3B5BFF'),
        ink: themeColor('--uisi-ink', '#111B4D'),
        muted: themeColor('--uisi-muted', '#526184'),
        line: themeColor('--uisi-blue-line', '#D4DEFF'),
        soft: themeColor('--uisi-blue-soft', '#EAF0FF'),
        surface: themeColor('--uisi-surface', '#FFFFFF'),
        success: themeColor('--uisi-success', '#176B50'),
        warning: themeColor('--uisi-warning', '#8A5A12'),
        danger: themeColor('--uisi-danger', '#A6243E'),
    };
    const form = root.querySelector('#analytics-filters');
    const results = root.querySelector('#analytics-results');
    const status = root.querySelector('#analytics-status');
    const error = root.querySelector('#analytics-error');
    const notice = root.querySelector('#analytics-filter-notice');
    const exportExcelButton = root.querySelector('#analytics-export-excel');
    const exportImageButton = root.querySelector('#analytics-export-image');
    const exportButtons = [exportExcelButton, exportImageButton];
    const number = new Intl.NumberFormat('id-ID');
    const rupiah = new Intl.NumberFormat('id-ID', {style: 'currency', currency: 'IDR', maximumFractionDigits: 0});
    const compactNumber = new Intl.NumberFormat('id-ID', {maximumFractionDigits: 2});
    function compactRupiah(value) {
        const unit = [[1e12, 'triliun'], [1e9, 'miliar'], [1e6, 'juta']].find(([amount]) => value >= amount);
        return unit ? `Rp ${compactNumber.format(value / unit[0])} ${unit[1]}` : rupiah.format(value);
    }
    const dateFormat = new Intl.DateTimeFormat('id-ID', {day: 'numeric', month: 'short', year: 'numeric', timeZone: 'UTC'});
    const monthFormat = new Intl.DateTimeFormat('id-ID', {month: 'long', year: 'numeric', timeZone: 'UTC'});
    const dateLabel = value => dateFormat.format(new Date(`${value}T12:00:00Z`));
    const today = form.elements.end_date.max;
    const defaults = Object.fromEntries(new FormData(form));
    const fields = Object.keys(defaults);
    const programOptions = [...form.elements.program_id.options].map(option => option.cloneNode(true));
    const charts = [...root.querySelectorAll('[data-chart]')];
    const labels = {category: 'Kategori', program_id: 'Pelatihan', payment_status: 'Pembayaran', participant_status: 'Peserta', interval: 'Tren'};
    const config = {responsive: true, displaylogo: false, displayModeBar: false, scrollZoom: false,
        modeBarButtonsToRemove: ['lasso2d', 'select2d', 'toImage', 'toggleSpikelines', 'hoverClosestCartesian', 'hoverCompareCartesian', 'autoScale2d'],
        toImageButtonOptions: {format: 'png', scale: 2, filename: 'uisi-analitik'}};
    let current = null;
    let revision = 0;
    let controller = null;
    let renderQueue = Promise.resolve();

    const filterToggle = root.querySelector('#analytics-filter-toggle');
    const filterDrawer = root.querySelector('#analytics-filter-drawer');
    function showFilters(open) {
        filterDrawer.hidden = !open;
        filterToggle.setAttribute('aria-expanded', String(open));
    }
    filterToggle.addEventListener('click', () => showFilters(filterDrawer.hidden));

    function updateHighlights(payload) {
        const registrationCount = payload.programs.filter(program => program.registrations > 0).length;
        const popularityCount = payload.programs.filter(program => program.registrations > 0 && program.capacity > 0).length;
        const revenueCount = payload.programs.filter(program => program.actual_revenue > 0).length;
        const rankLabel = count => count ? `${Math.min(5, count)} dari ${number.format(count)}` : 'Tidak ada data';
        root.querySelector('#analytics-registration-rank-count').textContent = rankLabel(registrationCount);
        root.querySelector('#analytics-popularity-rank-count').textContent = rankLabel(popularityCount);
        root.querySelector('#analytics-revenue-rank-count').textContent = rankLabel(revenueCount);
        const peak = payload.periods.reduce((best, period) => period.actual_revenue > (best?.actual_revenue ?? 0) ? period : best, null);
        root.querySelector('#analytics-revenue-insight').textContent = peak
            && peak.actual_revenue > 0
            ? `Puncak pendapatan ${compactRupiah(peak.actual_revenue)} terjadi pada ${monthFormat.format(new Date(`${peak.start_date}T12:00:00Z`))}.`
            : 'Belum ada penerimaan pembayaran tercatat pada periode ini.';
        const registrationLeader = [...payload.programs]
            .filter(program => program.registrations > 0)
            .sort((a, b) => b.registrations - a.registrations || a.title.localeCompare(b.title) || a.id - b.id)[0];
        root.querySelector('#analytics-registration-insight').textContent = registrationLeader
            ? `Pendaftar terbanyak: ${registrationLeader.title}, ${number.format(registrationLeader.registrations)} orang.`
            : 'Belum ada pendaftaran yang dapat dibandingkan pada periode ini.';
        const eligible = payload.programs.filter(p => p.capacity > 0 && p.registrations > 0);
        const missing = payload.programs.filter(p => p.registrations > 0 && !p.capacity).length;
        const leader = eligible.sort((a, b) => b.registrations / b.capacity - a.registrations / a.capacity || b.registrations - a.registrations || a.title.localeCompare(b.title) || a.id - b.id)[0];
        root.querySelector('#analytics-program-insight').textContent = eligible.length
            ? `Minat tertinggi: ${leader.title}, ${number.format(leader.popularity_rate)}% kapasitas.` + (missing ? ` ${missing} pelatihan belum memiliki kapasitas.` : '')
            : payload.empty ? 'Belum ada pendaftaran sesuai filter.' : 'Isi kapasitas program terlebih dahulu untuk membandingkan minat.';
        const topRevenue = [...payload.programs]
            .filter(program => program.actual_revenue > 0)
            .sort((a, b) => b.actual_revenue - a.actual_revenue || a.title.localeCompare(b.title) || a.id - b.id)[0];
        root.querySelector('#analytics-top-revenue-program').textContent = topRevenue?.title ?? 'Belum ada';
        root.querySelector('#analytics-top-revenue-amount').textContent = topRevenue
            ? `${rupiah.format(topRevenue.actual_revenue)} pendapatan diterima`
            : 'Belum ada pendapatan diterima';
        const revenueShare = topRevenue && payload.summary.actual_revenue
            ? topRevenue.actual_revenue / payload.summary.actual_revenue * 100
            : 0;
        root.querySelector('#analytics-program-revenue-insight').textContent = topRevenue
            ? `${topRevenue.title} berkontribusi ${number.format(revenueShare)}% dari total pendapatan (${compactRupiah(topRevenue.actual_revenue)}).`
            : 'Belum ada pendapatan pelatihan yang dapat dibandingkan.';
        const receiptNotice = root.querySelector('#analytics-receipt-notice');
        receiptNotice.replaceChildren();
        receiptNotice.hidden = !payload.summary.missing_receipts;
        if (payload.summary.missing_receipts) {
            receiptNotice.append(`${number.format(payload.summary.missing_receipts)} pembayaran disetujui belum memiliki nominal tersimpan. Pemeriksaan ini mencakup semua tanggal pada program/status terpilih. `);
            const link = document.createElement('a');
            link.href = payload.receipts_completion_url;
            link.textContent = 'Lengkapi data pembayaran →';
            link.style.textDecoration = 'underline';
            receiptNotice.append(link);
        }
        
        if (payload.visitors) {
            const viewedPrograms = payload.visitors.popular_training_views ?? [];
            const topViewedProgram = viewedPrograms[0] ?? null;
            root.querySelector('#analytics-views-rank-count').textContent = rankLabel(viewedPrograms.length);
            root.querySelector('#analytics-views-insight').textContent = topViewedProgram
                ? `Halaman paling banyak dilihat: ${topViewedProgram.title}, ${number.format(topViewedProgram.views)} tampilan.`
                : 'Belum ada tampilan halaman pelatihan pada periode ini.';
            const conversionRate = payload.visitors.conversion_rate == null
                ? 'belum tersedia'
                : `${number.format(payload.visitors.conversion_rate)}%`;
            root.querySelector('#analytics-visitors-insight').textContent = payload.visitors.total_visitors || payload.visitors.website_registrants
                ? `Tercatat ${number.format(payload.visitors.total_visitors)} pengunjung unik dan ${number.format(payload.visitors.website_registrants)} pendaftar dari situs web. Tingkat konversinya ${conversionRate}.`
                : 'Belum ada kunjungan atau pendaftaran pada periode ini.';
            root.querySelector('#analytics-interaction-insight').textContent = 'Pendaftar pada grafik memiliki ID sesi yang cocok dengan pengunjung pada periode yang sama.';
        }
    }

    function programComparison(payload, key, width) {
        const revenue = key === 'program_revenue';
        const field = revenue ? 'actual_revenue' : 'registrations';
        const rows = [...payload.programs].filter(row => row[field] > 0)
            .sort((a, b) => b[field] - a[field] || a.title.localeCompare(b.title) || a.id - b.id).slice(0, 5);
        const escape = text => String(text).replace(/[&<>"']/g, char => ({'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[char]));
        const lineLimit = width < 420 ? 14 : 20;
        const formatLabel = value => {
            const title = String(value);
            const shortened = title.length > lineLimit * 2 ? `${title.slice(0, lineLimit * 2 - 1)}…` : title;
            if (shortened.length <= lineLimit) return escape(shortened);
            const breakAt = shortened.lastIndexOf(' ', lineLimit);
            const splitAt = breakAt > Math.floor(lineLimit * .55) ? breakAt : lineLimit;
            return `${escape(shortened.slice(0, splitAt))}<br>${escape(shortened.slice(splitAt).trim())}`;
        };
        const maximum = Math.max(1, ...rows.map(row => row[field]));
        const colors = rows.map((row, index) => index === 0 ? palette.brand : palette.muted);
        const layout = {
            paper_bgcolor:'rgba(0,0,0,0)', plot_bgcolor:'rgba(0,0,0,0)',
            font:{family:'Inter, Arial, sans-serif', size:10, color:palette.muted},
            margin:{l:width < 420 ? 112 : 158, r:width < 420 ? 34 : 55, t:14, b:42},
            showlegend:false, dragmode:false, separators:',.',
            hoverlabel:{bgcolor:palette.brand, bordercolor:palette.line, font:{size:11, color:palette.surface}, align:'left'},
            xaxis:{range:[0, maximum * 1.28], fixedrange:true, showgrid:true, gridcolor:palette.soft, griddash:'dot', zeroline:false, nticks:4,
                title:{text:revenue ? 'Pendapatan diterima' : 'Jumlah pendaftar', standoff:10, font:{size:10, color:palette.muted}}},
            yaxis:{type:'category', categoryorder:'array', categoryarray:rows.map(row => String(row.id)),
                autorange:'reversed', fixedrange:true, showgrid:false, tickvals:rows.map(row => String(row.id)),
                tickfont:{size:12, color:palette.ink},
                ticktext:rows.map(row => formatLabel(row.title))},
            annotations:[],
        };
        if (revenue) {
            layout.xaxis.tickvals = [0, maximum / 2, maximum];
            layout.xaxis.ticktext = layout.xaxis.tickvals.map(compactRupiah);
        } else if (maximum <= 5) layout.xaxis.dtick = 1;
        else layout.xaxis.tickformat = ',d';
        if (!rows.length) {
            layout.xaxis.visible = false; layout.yaxis.visible = false;
            layout.annotations = [{text:revenue ? 'Belum ada pemasukan diterima' : 'Belum ada pendaftaran',
                x:.5, y:.5, xref:'paper', yref:'paper', showarrow:false}];
        }
        return {layout, data:rows.length ? [{type:'bar', orientation:'h',
            x:rows.map(row => row[field]), y:rows.map(row => String(row.id)), width:.52,
            marker:{color:colors, cornerradius:7, line:{color:palette.soft, width:1}},
            text:rows.map(row => revenue ? compactRupiah(row[field]) : number.format(row[field])),
            textposition:'outside', textfont:{size:12, color:palette.brand}, cliponaxis:false,
            customdata:rows.map(row => [row.id, escape(row.title), revenue ? rupiah.format(row[field]) : number.format(row[field])]),
            hovertemplate:'%{customdata[1]}<br>%{customdata[2]}' + (revenue ? ' diterima' : ' pendaftaran') + '<extra></extra>',
        }] : []};
    }

    function popularityComparison(payload, width) {
        const rows = [...payload.programs]
            .filter(row => row.capacity > 0 && row.registrations > 0)
            .sort((a, b) => b.popularity_rate - a.popularity_rate || b.registrations - a.registrations || a.title.localeCompare(b.title) || a.id - b.id)
            .slice(0, 5);
        const escape = text => String(text).replace(/[&<>"']/g, char => ({'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[char]));
        const lineLimit = width < 420 ? 14 : 20;
        const formatLabel = value => {
            const title = String(value);
            const shortened = title.length > lineLimit * 2 ? `${title.slice(0, lineLimit * 2 - 1)}…` : title;
            if (shortened.length <= lineLimit) return escape(shortened);
            const breakAt = shortened.lastIndexOf(' ', lineLimit);
            const splitAt = breakAt > Math.floor(lineLimit * .55) ? breakAt : lineLimit;
            return `${escape(shortened.slice(0, splitAt))}<br>${escape(shortened.slice(splitAt).trim())}`;
        };
        const maximum = Math.max(100, ...rows.map(row => row.popularity_rate));
        const ticks = [0, 25, 50, 75, 100];
        if (maximum > 100) ticks.push(maximum);
        const withinCapacity = rows.map(row => Math.min(100, row.popularity_rate));
        const overflow = rows.map(row => Math.max(0, row.popularity_rate - 100));
        const customdata = rows.map(row => [row.id, escape(row.title), row.registrations, row.capacity, row.popularity_rate]);
        const layout = {
            paper_bgcolor:'rgba(0,0,0,0)', plot_bgcolor:'rgba(0,0,0,0)',
            font:{family:'Inter, Arial, sans-serif', size:11, color:palette.muted},
            margin:{l:width < 420 ? 112 : 158, r:width < 420 ? 42 : 62, t:12, b:40},
            showlegend:false, dragmode:false, barmode:'stack', separators:',.',
            hoverlabel:{bgcolor:palette.brand, bordercolor:palette.line, font:{size:12, color:palette.surface}, align:'left'},
            xaxis:{range:[0, maximum * 1.16], fixedrange:true, showgrid:true, gridcolor:palette.soft, griddash:'dot', zeroline:false,
                tickvals:ticks, ticktext:ticks.map(value => `${number.format(value)}%`)},
            yaxis:{type:'category', categoryorder:'array', categoryarray:rows.map(row => String(row.id)), autorange:'reversed', fixedrange:true,
                showgrid:false, tickvals:rows.map(row => String(row.id)), ticktext:rows.map(row => formatLabel(row.title)), tickfont:{size:12, color:palette.ink}},
            shapes:[{type:'line', x0:100, x1:100, y0:0, y1:1, xref:'x', yref:'paper', line:{color:palette.muted, width:1, dash:'dot'}}],
            annotations:[],
        };
        if (!rows.length) {
            layout.xaxis.visible = false;
            layout.yaxis.visible = false;
            layout.shapes = [];
            layout.margin = {l:16, r:16, t:16, b:16};
            layout.annotations = [{text:'Belum ada data minat pelatihan', x:.5, y:.5, xref:'paper', yref:'paper', showarrow:false}];
        }
        return {layout, data:rows.length ? [
            {
                type:'bar', orientation:'h', width:.48, name:'Dalam kapasitas',
                x:withinCapacity, y:rows.map(row => String(row.id)),
                marker:{color:rows.map((row, index) => index === 0 ? palette.brand : palette.muted), cornerradius:6},
                text:rows.map((row, index) => overflow[index] > 0 ? '' : `${number.format(row.popularity_rate)}%`),
                textposition:'outside', textfont:{size:12, color:palette.brand}, cliponaxis:false, customdata,
                hovertemplate:'%{customdata[1]}<br>%{customdata[2]:,.0f} pendaftar dari %{customdata[3]:,.0f} kapasitas<br>Tingkat minat: %{customdata[4]:.1f}%<extra></extra>',
            },
            {
                type:'bar', orientation:'h', width:.48, name:'Melebihi kapasitas',
                x:overflow, y:rows.map(row => String(row.id)),
                marker:{color:palette.accent, cornerradius:6},
                text:rows.map((row, index) => overflow[index] > 0 ? `${number.format(row.popularity_rate)}%` : ''),
                textposition:'outside', textfont:{size:12, color:palette.brand}, cliponaxis:false, customdata,
                hovertemplate:'%{customdata[1]}<br>%{customdata[2]:,.0f} pendaftar dari %{customdata[3]:,.0f} kapasitas<br>Melebihi kapasitas · %{customdata[4]:.1f}%<extra></extra>',
            },
        ] : []};
    }

    function viewPopularityComparison(payload, width) {
        const rows = [...(payload.visitors?.popular_training_views ?? [])].slice(0, 5);
        const escape = text => String(text).replace(/[&<>"']/g, char => ({'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[char]));
        const lineLimit = width < 420 ? 14 : 20;
        const formatLabel = value => {
            const title = String(value);
            const shortened = title.length > lineLimit * 2 ? `${title.slice(0, lineLimit * 2 - 1)}…` : title;
            if (shortened.length <= lineLimit) return escape(shortened);
            const breakAt = shortened.lastIndexOf(' ', lineLimit);
            const splitAt = breakAt > Math.floor(lineLimit * .55) ? breakAt : lineLimit;
            return `${escape(shortened.slice(0, splitAt))}<br>${escape(shortened.slice(splitAt).trim())}`;
        };
        const maximum = Math.max(1, ...rows.map(row => row.views));
        const layout = {
            paper_bgcolor:'rgba(0,0,0,0)', plot_bgcolor:'rgba(0,0,0,0)',
            font:{family:'Inter, Arial, sans-serif', size:11, color:palette.muted},
            margin:{l:width < 420 ? 110 : 158, r:width < 420 ? 36 : 48, t:12, b:38},
            showlegend:false, dragmode:false, separators:',.',
            hoverlabel:{bgcolor:palette.surface, bordercolor:palette.line, font:{size:12, color:palette.ink}, align:'left'},
            xaxis:{range:[0, maximum * 1.24], fixedrange:true, showgrid:true, gridcolor:palette.soft, griddash:'dot', zeroline:false, tickformat:',d', nticks:4},
            yaxis:{type:'category', categoryorder:'array', categoryarray:rows.map(row => String(row.program_id)), autorange:'reversed', fixedrange:true,
                showgrid:false, tickvals:rows.map(row => String(row.program_id)), ticktext:rows.map(row => formatLabel(row.title)), tickfont:{size:12, color:palette.ink}},
            annotations:[],
        };
        if (!rows.length) {
            layout.xaxis.visible = false;
            layout.yaxis.visible = false;
            layout.margin = {l:16, r:16, t:16, b:16};
            layout.annotations = [{text:'Belum ada tampilan halaman pelatihan', x:.5, y:.5, xref:'paper', yref:'paper', showarrow:false}];
        }
        return {layout, data:rows.length ? [{
            type:'bar', orientation:'h', width:.5,
            x:rows.map(row => row.views), y:rows.map(row => String(row.program_id)),
            marker:{color:palette.brand, cornerradius:6},
            text:rows.map(row => number.format(row.views)), textposition:'outside', textfont:{size:12, color:palette.brand}, cliponaxis:false,
            customdata:rows.map(row => [row.program_id, escape(row.title), row.views]),
            hovertemplate:'%{customdata[1]}<br>%{customdata[2]:,.0f} tampilan halaman<extra></extra>',
        }] : []};
    }

    function statusCapacityChart(payload, key, width) {
        const escape = text => String(text).replace(/[&<>"']/g, char => ({'&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;'}[char]));
        const layout = {
            paper_bgcolor:'rgba(0,0,0,0)', plot_bgcolor:'rgba(0,0,0,0)',
            font:{family:'Inter, Arial, sans-serif', size:10, color:palette.muted},
            hoverlabel:{bgcolor:palette.brand, bordercolor:palette.line, font:{size:11, color:palette.surface}, align:'left'},
            margin:{l:130, r:32, t:12, b:32}, showlegend:false, dragmode:false, separators:',.',
            xaxis:{fixedrange:true, showgrid:true, gridcolor:palette.soft, zeroline:false, tickformat:',d', nticks:4},
            yaxis:{type:'category', autorange:'reversed', fixedrange:true, showgrid:false}, annotations:[],
        };
        const empty = message => {
            layout.xaxis.visible = false; layout.yaxis.visible = false;
            layout.margin = {l:16, r:16, t:16, b:16};
            layout.annotations = [{text:message, x:.5, y:.5, xref:'paper', yref:'paper', showarrow:false}];
            return {data:[], layout};
        };
        if (key === 'capacity_total') {
            if (!payload.snapshot.capacity) return empty('Kapasitas belum ditentukan');
            layout.margin = {l:16, r:16, t:16, b:40};
            layout.showlegend = true;
            layout.legend = {orientation:'h', x:.5, xanchor:'center', y:-.08, font:{size:10}};
            layout.annotations = [{text:`<b>${number.format(payload.snapshot.occupied / payload.snapshot.capacity * 100)}%</b><br>terisi`,
                x:.5, y:.5, xref:'paper', yref:'paper', showarrow:false, font:{size:16, color:palette.ink}}];
            return {layout, data:[{type:'pie', labels:['Terisi', 'Tersisa'],
                values:[payload.snapshot.occupied, payload.snapshot.remaining], hole:.74,
                sort:false, direction:'clockwise', textinfo:'none',
                marker:{colors:[palette.brand, palette.soft], line:{color:palette.surface, width:3}},
                hovertemplate:'%{label}: %{value:,.0f} kursi<br>%{percent}<extra></extra>'}]};
        }
        if (key === 'capacity_programs') {
            const rows = [...payload.snapshot.programs].filter(row => row.capacity > 0)
                .sort((a,b) => b.occupied / b.capacity - a.occupied / a.capacity || b.occupied - a.occupied || a.id - b.id).slice(0,5);
            if (!rows.length) return empty('Kapasitas belum ditentukan');
            layout.barmode = 'stack'; layout.showlegend = true;
            layout.margin = {l:width < 420 ? 110 : 140, r:20, t:12, b:48};
            layout.legend = {orientation:'h', x:0, y:-.24, font:{size:9}};
            layout.yaxis.categoryorder = 'array'; layout.yaxis.categoryarray = rows.map(row => String(row.id));
            layout.yaxis.tickvals = rows.map(row => String(row.id));
            layout.yaxis.ticktext = rows.map(row => escape(row.title.length > 18 ? row.title.slice(0,17) + '…' : row.title));
            layout.xaxis.range = [0, Math.max(...rows.map(row => row.capacity)) * 1.04];
            return {layout, data:[['occupied','Terisi',palette.brand],['remaining','Tersisa',palette.soft]].map(([field,name,color]) => ({
                type:'bar', orientation:'h', name, width:.45, x:rows.map(row => row[field]), y:rows.map(row => String(row.id)),
                marker:{color}, customdata:rows.map(row => [row.id, escape(row.title), row.capacity]),
                hovertemplate:`%{customdata[1]}<br>${name}: %{x:,.0f} kursi<br>Kapasitas: %{customdata[2]:,.0f}<extra></extra>`,
            }))};
        }
        const rows = (key === 'payment_status' ? payload.payment_breakdown : payload.participant_breakdown).filter(row => row.count > 0);
        if (!rows.length) return empty('Belum ada pendaftaran sesuai filter');
        const colors = {disetujui:palette.success, diterima:palette.success, menunggu_pembayaran:palette.muted, menunggu_verifikasi:palette.warning, diproses:palette.accent, ditolak:palette.danger, unknown:palette.muted};
        const maximum = Math.max(...rows.map(row => row.count));
        layout.xaxis.range = [0, maximum * 1.2];
        if (maximum < 5) layout.xaxis.dtick = 1;
        layout.yaxis.categoryorder = 'array'; layout.yaxis.categoryarray = rows.map(row => row.status);
        layout.yaxis.tickvals = rows.map(row => row.status); layout.yaxis.ticktext = rows.map(row => escape(row.label));
        return {layout, data:[{type:'bar', orientation:'h', width:.4,
            x:rows.map(row => row.count), y:rows.map(row => row.status),
            marker:{color:rows.map(row => colors[row.status] ?? palette.muted), cornerradius:4},
            text:rows.map(row => number.format(row.count)), textposition:'outside', cliponaxis:false,
            customdata:rows.map(row => [row.status, escape(row.label)]),
            hovertemplate:'%{customdata[1]}<br>%{x:,.0f} pendaftaran<extra></extra>',
        }]};
    }

    function renderCharts(payload) {
        return Promise.all(charts.filter(element => !element.closest('[role="tabpanel"]').hidden).map(async element => {
            const width = element.clientWidth;
            const ranking = element.dataset.chart === 'popular_programs';
            const viewsRanking = element.dataset.chart === 'popular_programs_views';
            const programChart = ['program_registrations', 'program_revenue'].includes(element.dataset.chart);
            const supplementalChart = ['payment_status', 'participant_status', 'capacity_total', 'capacity_programs'].includes(element.dataset.chart);
            
            let chart = programChart ? programComparison(payload, element.dataset.chart, width)
                : ranking ? popularityComparison(payload, width)
                : viewsRanking ? viewPopularityComparison(payload, width)
                : supplementalChart ? statusCapacityChart(payload, element.dataset.chart, width)
                : structuredClone(payload.charts[element.dataset.chart] || {});

            if (!chart || !chart.layout) {
                element.innerHTML = `<div style="display:flex;align-items:center;justify-content:center;height:100%;min-height:200px;color:${palette.muted};font-size:14px;padding:2rem;">Belum ada data tersedia</div>`;
                return;
            }
            
            const rowCount = chart.data[0]?.y.length ?? 0;
            element.style.height = ranking || viewsRanking || programChart ? `${Math.max(130, rowCount * 34 + 78)}px` : '';
            chart.layout.autosize = true;
            if (chart.layout.font) chart.layout.font.size = 12;
            if (chart.layout.hoverlabel && chart.layout.hoverlabel.font) chart.layout.hoverlabel.font.size = 12;
            chart.layout.dragmode = false;
            chart.layout.xaxis.fixedrange = true;
            chart.layout.yaxis.fixedrange = true;
            chart.layout.xaxis.showspikes = false;
            chart.layout.yaxis.showspikes = false;
            if (element.dataset.chart === 'revenue_trend' && chart.data.length) {
                chart.layout.margin = {l: 72, r: 18, t: 18, b: 38};
                chart.layout.xaxis.tickfont = {size: 12, color: palette.muted};
                chart.layout.yaxis.tickfont = {size: 12, color: palette.muted};
                chart.layout.hovermode = 'closest';
                chart.data[0].line.width = 3;
                chart.data[0].line.shape = 'linear';
                chart.data[0].line.smoothing = 0;
                chart.data[0].line.color = palette.brand;
                chart.data[0].marker.size = 8;
                chart.data[0].marker.color = palette.brand;
                chart.data[0].marker.line = {color:palette.surface, width:2};
                chart.data[0].fillcolor = 'rgba(29, 78, 216, 0.10)';
                const peakValue = Math.max(...chart.data[0].y);
                let peakShown = false;
                chart.data[0].text = chart.data[0].y.map(value => {
                    if (!peakShown && value === peakValue && value > 0) {
                        peakShown = true;
                        return `<b>${compactRupiah(value)}</b>`;
                    }
                    return '';
                });
                chart.data[0].textfont = {size:12, color:palette.brand};
                chart.data[0].textposition = 'top center';
            }
            if (element.dataset.chart === 'revenue_trend' && chart.data.length) {
                const axis = chart.layout.xaxis;
                const limit = Math.max(2, Math.floor((width - 90) / (width < 420 ? 38 : 90)));
                const count = Math.min(limit, axis.tickvals.length);
                const keep = [...new Set(Array.from({length: count}, (_, i) => Math.round(i * (axis.tickvals.length - 1) / Math.max(1, count - 1))))];
                axis.ticktext = keep.map(index => width < 420 ? axis.ticktext[index].replace(/ (\d{4})$/, '<br>$1') : axis.ticktext[index]);
                axis.tickvals = keep.map(index => axis.tickvals[index]);
                chart.data[0].mode = chart.data[0].text.length ? 'lines+markers+text' : 'lines+markers';
            }
            if (width < 420) {
                chart.layout.font.size = 11;
                chart.layout.margin.l = element.dataset.chart === 'revenue_trend' ? 76 : supplementalChart ? chart.layout.margin.l : programChart || ranking || viewsRanking ? 110 : 18;
                chart.layout.margin.r = 18;
            }
            await Plotly.react(element, chart.data, chart.layout, config);
            element.removeAllListeners?.('plotly_click');
            if (['popular_programs', 'popular_programs_views', 'program_registrations', 'program_revenue'].includes(element.dataset.chart)) {
                element.on('plotly_click', event => {
                    const id = event.points?.[0]?.customdata?.[0];
                    if (id) focusProgram(id);
                });
            }
        }));
    }

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (current && results.getAttribute('aria-busy') !== 'true') {
                renderQueue = renderQueue.catch(() => {}).then(() => renderCharts(current));
                renderQueue.catch(() => { error.hidden = false; error.textContent = 'Grafik belum dapat ditampilkan. Silakan muat ulang.'; });
            }
        }, 180);
    });

    const tabs = [...root.querySelectorAll('[role="tab"]')];
    function selectTab(tab) {
        if (results.getAttribute('aria-busy') === 'true') return;
        tabs.forEach(button => {
            const active = button === tab;
            button.setAttribute('aria-selected', String(active));
            button.tabIndex = active ? 0 : -1;
            root.querySelector(`#${button.getAttribute('aria-controls')}`).hidden = !active;
        });
        if (current) {
            renderQueue = renderQueue.catch(() => {}).then(() => renderCharts(current));
            renderQueue.catch(() => {error.hidden = false; error.textContent = 'Grafik belum dapat ditampilkan. Silakan muat ulang.';});
        }
    }
    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => selectTab(tab));
        tab.addEventListener('keydown', event => {
            const next = {ArrowRight: (index + 1) % tabs.length, ArrowLeft: (index + tabs.length - 1) % tabs.length, Home: 0, End: tabs.length - 1}[event.key];
            if (next === undefined) return;
            event.preventDefault();
            selectTab(tabs[next]);
            tabs[next].focus();
        });
    });
    root.querySelectorAll('[data-open-tab]').forEach(button => button.addEventListener('click', () => {
        selectTab(root.querySelector(`#ana-tab-${button.dataset.openTab}`));
    }));
    function focusPayment(paymentStatus) {
        if (!current || results.getAttribute('aria-busy') === 'true') return;
        restore(current.filters);
        form.elements.payment_status.value = paymentStatus;
        load();
        form.scrollIntoView({behavior: 'smooth', block: 'start'});
    }
    root.querySelectorAll('[data-payment-filter]').forEach(button => button.addEventListener('click', () => focusPayment(button.dataset.paymentFilter)));

    function periodStart(period) {
        const start = new Date(`${today}T12:00:00Z`);
        if (['7', '30'].includes(period)) start.setUTCDate(start.getUTCDate() - Number(period) + 1);
        else if (period === '6months') {start.setUTCDate(1); start.setUTCMonth(start.getUTCMonth() - 5);}
        else if (period === 'year') start.setUTCMonth(0, 1);
        return period === 'all' ? root.dataset.firstDate : start.toISOString().slice(0, 10);
    }

    function selectedLabel(key, value) {
        if (key === 'interval') return 'Per bulan';
        const options = key === 'program_id' ? programOptions : [...form.elements[key].options];
        return options.find(option => option.value === String(value ?? ''))?.textContent ?? String(value ?? '');
    }

    function syncPrograms() {
        const previous = form.elements.program_id.value;
        const category = form.elements.category.value;
        const compatible = programOptions.filter(option => !option.value || !category || option.dataset.category === category);
        form.elements.program_id.replaceChildren(...compatible.map(option => option.cloneNode(true)));
        const retained = compatible.some(option => option.value === previous);
        form.elements.program_id.value = retained ? previous : '';
        notice.hidden = retained || !previous;
        notice.textContent = 'Program direset karena tidak termasuk dalam kategori yang baru dipilih.';
    }

    function setBusy(busy) {
        results.setAttribute('aria-busy', String(busy));
        results.style.opacity = busy ? '0.4' : '1';
        results.style.pointerEvents = busy ? 'none' : '';
        exportButtons.forEach(button => { button.disabled = busy || !current; });
    }

    function cell(row, value) {
        const element = document.createElement('td');
        element.textContent = value;
        row.append(element);
        return element;
    }

    function fillTable(programs) {
        const body = root.querySelector('#analytics-table');
        if (!body) return;
        body.replaceChildren();
        if (!programs.length) {
            const row = document.createElement('tr');
            cell(row, 'Tidak ada pendaftaran sesuai filter.').colSpan = 7;
            body.append(row);
        }
        for (const p of programs) {
            const row = document.createElement('tr');
            const title = cell(row, '');
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'ana-program-name';
            button.textContent = p.title;
            button.addEventListener('click', () => focusProgram(p.id));
            const detail = document.createElement('p');
            detail.className = 'ana-program-meta';
            detail.textContent = `${p.category} · ${rupiah.format(p.price)}`;
            title.append(button, detail);
            cell(row, number.format(p.registrations));
            cell(row, p.capacity ? `${number.format(p.registrations)} / ${number.format(p.capacity)} (${number.format(p.popularity_rate)}%)` : 'Kapasitas belum diatur');
            const paymentCell = cell(row, '');
            const approved = document.createElement('p');
            approved.className = 'ana-payment-approved';
            approved.textContent = `${number.format(p.approved)} disetujui`;
            const paymentDetails = document.createElement('details');
            paymentDetails.className = 'ana-payment-detail';
            const summary = document.createElement('summary');
            const waiting = (p.payments.menunggu_pembayaran ?? 0) + (p.payments.menunggu_verifikasi ?? 0);
            summary.textContent = `${number.format(waiting)} menunggu · rincian`;
            paymentDetails.append(summary);
            for (const [key, label] of Object.entries({menunggu_pembayaran: 'Menunggu bayar', menunggu_verifikasi: 'Menunggu verifikasi', ditolak: 'Ditolak', unknown: 'Belum diklasifikasi'})) {
                const line = document.createElement('p');
                line.textContent = `${label}: ${number.format(p.payments[key] ?? 0)}`;
                paymentDetails.append(line);
            }
            paymentCell.append(approved, paymentDetails);
            cell(row, number.format(p.participants.diterima ?? 0));
            const income = cell(row, p.missing_receipts && !p.receipt_count ? 'Belum lengkap' : rupiah.format(p.actual_revenue));
            if (p.missing_receipts) { const note = document.createElement('small'); note.className = 'ana-program-meta'; note.textContent = ` · ${number.format(p.missing_receipts)} pembayaran belum dicatat`; income.append(note); }
            const link = document.createElement('a');
            link.href = p.participants_url;
            link.textContent = 'Lihat peserta';
            link.className = 'ana-detail-link';
            cell(row, '').append(link);
            body.append(row);
        }
    }

    function fillAccessibleTables(payload) {
        const activityBody = root.querySelector('#analytics-activity-data');
        const activityRows = [...payload.programs]
            .filter(program => program.registrations > 0)
            .sort((a, b) => b.registrations - a.registrations || a.title.localeCompare(b.title));
        activityBody.replaceChildren();
        if (!activityRows.length) {
            const row = document.createElement('tr');
            cell(row, 'Belum ada data aktivitas sesuai filter.').colSpan = 5;
            activityBody.append(row);
        }
        for (const program of activityRows) {
            const row = document.createElement('tr');
            cell(row, program.title);
            cell(row, number.format(program.registrations));
            cell(row, program.capacity ? number.format(program.capacity) : 'Belum diatur');
            cell(row, program.popularity_rate == null ? 'Belum diatur' : `${number.format(program.popularity_rate)}%`);
            const statusCell = cell(row, !program.capacity ? 'Kapasitas belum diatur'
                : program.popularity_rate > 100 ? 'Melebihi kapasitas'
                    : program.popularity_rate === 100 ? 'Kapasitas penuh' : 'Dalam kapasitas');
            if (program.popularity_rate > 100) statusCell.className = 'ana-table-warning';
            activityBody.append(row);
        }

        const financeBody = root.querySelector('#analytics-finance-data');
        const financeRows = [...payload.programs]
            .filter(program => program.actual_revenue > 0)
            .sort((a, b) => b.actual_revenue - a.actual_revenue || a.title.localeCompare(b.title));
        financeBody.replaceChildren();
        if (!financeRows.length) {
            const row = document.createElement('tr');
            cell(row, 'Belum ada data keuangan sesuai filter.').colSpan = 4;
            financeBody.append(row);
        }
        for (const program of financeRows) {
            const row = document.createElement('tr');
            cell(row, program.title);
            cell(row, number.format(program.receipt_count));
            cell(row, rupiah.format(program.actual_revenue));
            const contribution = payload.summary.actual_revenue
                ? program.actual_revenue / payload.summary.actual_revenue * 100
                : 0;
            cell(row, `${number.format(contribution)}%`);
            financeBody.append(row);
        }

        const visitorsTrendBody = root.querySelector('#analytics-visitors-trend-data');
        visitorsTrendBody.replaceChildren();
        const visitorPeriods = payload.visitors?.periods ?? [];
        if (!visitorPeriods.length) {
            const row = document.createElement('tr');
            cell(row, 'Belum ada data pengunjung sesuai filter.').colSpan = 4;
            visitorsTrendBody.append(row);
        }
        for (const period of visitorPeriods) {
            const row = document.createElement('tr');
            cell(row, period.label);
            cell(row, number.format(period.unique_visitors));
            cell(row, number.format(period.website_registrants));
            cell(row, period.conversion_rate == null ? 'Belum tersedia' : `${number.format(period.conversion_rate)}%`);
            visitorsTrendBody.append(row);
        }

        const visitorsProgramBody = root.querySelector('#analytics-visitors-program-data');
        visitorsProgramBody.replaceChildren();
        const viewedPrograms = payload.visitors?.popular_training_views ?? [];
        if (!viewedPrograms.length) {
            const row = document.createElement('tr');
            cell(row, 'Belum ada halaman pelatihan yang dilihat.').colSpan = 2;
            visitorsProgramBody.append(row);
        }
        for (const program of viewedPrograms) {
            const row = document.createElement('tr');
            const title = cell(row, '');
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'ana-program-name';
            button.textContent = program.title;
            button.addEventListener('click', () => focusProgram(program.program_id));
            title.append(button);
            cell(row, number.format(program.views));
            visitorsProgramBody.append(row);
        }
    }

    function breakdown(selector, rows) {
        const container = root.querySelector(selector);
        if (!container) return;
        container.replaceChildren(...rows.map(item => {
            const line = document.createElement('div');
            line.className = 'ana-breakdown-row';
            const label = document.createElement('span');
            label.textContent = item.label;
            const count = document.createElement('span');
            count.className = 'ana-breakdown-value';
            count.textContent = item.value ?? `${number.format(item.count)}${item.percentage == null ? '' : ` (${number.format(item.percentage)}%)`}`;
            line.append(label, count);
            return line;
        }));
    }

    function appliedFilters(filters) {
        const container = root.querySelector('#analytics-applied');
        container.replaceChildren();
        const period = document.createElement('span');
        period.className = 'ana-chip';
        period.textContent = `Periode: ${dateLabel(filters.start_date)} sampai ${dateLabel(filters.end_date)}`;
        container.append(period);
        for (const [key, label] of Object.entries(labels)) {
            if (!filters[key]) continue;
            const chip = document.createElement('button');
            chip.type = 'button';
            chip.className = 'ana-chip';
            chip.textContent = `${label}: ${selectedLabel(key, filters[key])}${filters[key] && key !== 'interval' ? ' ×' : ''}`;
            chip.disabled = !filters[key] || key === 'interval';
            chip.setAttribute('aria-label', `Hapus filter ${label}`);
            chip.addEventListener('click', () => {
                restore(filters);
                form.elements[key].value = '';
                syncPrograms();
                load();
            });
            container.append(chip);
        }
        const extraCount = ['category', 'payment_status', 'participant_status'].filter(key => filters[key]).length;
        root.querySelector('#analytics-extra-count').textContent = extraCount ? `(${extraCount} aktif)` : '';
        let matched = false;
        root.querySelectorAll('[data-period]').forEach(button => {
            const active = !matched && filters.end_date === today && periodStart(button.dataset.period) === filters.start_date;
            button.setAttribute('aria-pressed', String(active));
            if (active) matched = true;
        });
    }

    function restore(filters) {
        form.elements.category.value = filters.category ?? '';
        syncPrograms();
        for (const key of fields) form.elements[key].value = filters[key] ?? '';
        if (filters.program_id && form.elements.program_id.value !== String(filters.program_id)) {
            form.elements.program_id.value = '';
            notice.hidden = false;
            notice.textContent = 'Program pada tautan tidak tersedia dalam kategori ini. Semua program dalam kategori ditampilkan.';
        }
    }

    function focusProgram(id) {
        if (!current || results.getAttribute('aria-busy') === 'true') return;
        restore(current.filters);
        form.elements.program_id.value = String(id);
        load();
        form.scrollIntoView({behavior: 'smooth', block: 'start'});
    }

    async function load() {
        form.elements.interval.value = 'month';
        const requestId = ++revision;
        controller?.abort();
        error.hidden = true;
        form.elements.end_date.min = form.elements.start_date.value;
        if (!form.checkValidity()) {
            showFilters(true);
            setBusy(false);
            exportButtons.forEach(button => { button.disabled = true; });
            error.textContent = 'Lengkapi tanggal yang valid. Tanggal akhir harus sama atau setelah tanggal mulai dan tidak melebihi hari ini.';
            error.hidden = false;
            status.textContent = current ? 'Filter belum diterapkan. Hasil masih memakai filter pada label di atas.' : 'Periksa filter untuk menampilkan data.';
            return;
        }
        const filters = Object.fromEntries(new FormData(form));
        controller = new AbortController();
        const activeController = controller;
        const timeout = setTimeout(() => activeController.abort(), 30000);
        setBusy(true);
        status.textContent = 'Memperbarui seluruh hasil sesuai filter…';
        try {
            const response = await fetch(`${root.dataset.endpoint}?${new URLSearchParams(filters)}`, {
                headers: {Accept: 'application/json'}, signal: activeController.signal, credentials: 'same-origin',
            });
            if (response.redirected || [401, 403].includes(response.status)) throw new Error('Sesi admin berakhir atau akses ditolak. Silakan masuk kembali.');
            const payload = await response.json();
            if (!response.ok) throw new Error(Object.values(payload.errors ?? {}).flat().join(' ') || payload.message);
            if (requestId !== revision) return;
            // Serialize rendering so an older Plotly update cannot overwrite newer filters.
            renderQueue = renderQueue.catch(() => {}).then(async () => {
                if (requestId !== revision) return;
                await renderCharts(payload);
            });
            await renderQueue;
            if (requestId !== revision) return;
            for (const metric of root.querySelectorAll('[data-metric]')) {
                const key = metric.dataset.metric;
                const value = payload.visitors?.[key] ?? payload.summary[key];
                metric.textContent = value === null || value === undefined ? 'Belum ada' : key === 'actual_revenue'
                    ? (metric.dataset.format === 'compact-currency' ? compactRupiah(value) : rupiah.format(value))
                    : (metric.dataset.format === 'percent' ? number.format(value) + '%' : number.format(value) + (key.endsWith('_rate') ? '%' : ''));
                if (metric.dataset.format === 'compact-currency') {
                    metric.setAttribute('aria-label', value === null ? 'Nominal belum lengkap' : rupiah.format(value));
                    metric.style.setProperty('--metric-font', `${170 / metric.textContent.length}cqi`);
                }
            }
            updateHighlights(payload);
            fillAccessibleTables(payload);
            root.querySelector('#analytics-empty').hidden = !payload.empty;
            current = payload;
            appliedFilters(payload.filters);
            const url = new URL(window.location.href);
            fields.forEach(key => filters[key] ? url.searchParams.set(key, filters[key]) : url.searchParams.delete(key));
            window.history.replaceState({}, '', url);
            status.textContent = `${number.format(payload.summary.registrations)} pendaftaran · ${number.format(payload.summary.conducted_programs)} pelatihan dilaksanakan · Diperbarui ${new Date(payload.generated_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}`;
        } catch (exception) {
            if (requestId !== revision) return;
            error.textContent = exception.name === 'AbortError' ? 'Pemuatan terlalu lama. Klik Muat ulang untuk mencoba kembali.' : exception.message;
            error.hidden = false;
            status.textContent = current ? 'Pembaruan gagal. Hasil masih memakai filter sebelumnya yang tertera di atas.' : 'Grafik belum tersedia.';
        } finally {
            clearTimeout(timeout);
            if (requestId === revision) setBusy(false);
        }
    }

    form.addEventListener('submit', event => {event.preventDefault(); load();});
    form.addEventListener('change', event => {
        notice.hidden = true;
        if (event.target.name === 'category') syncPrograms();
        load();
    });
    root.querySelector('#analytics-reset').addEventListener('click', () => {restore(defaults); notice.hidden = true; load();});
    root.querySelectorAll('[data-period]').forEach(button => button.addEventListener('click', () => {
        const period = button.dataset.period;
        form.elements.start_date.value = periodStart(period);
        form.elements.end_date.value = today;
        form.elements.interval.value = 'month';
        load();
    }));

    function downloadBlob(blob, filename) {
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.download = filename;
        document.body.append(link);
        link.click();
        link.remove();
        setTimeout(() => URL.revokeObjectURL(url), 1000);
    }

    exportExcelButton.addEventListener('click', () => {
        if (!current || exportExcelButton.disabled) return;
        const parameters = new URLSearchParams();
        Object.entries(current.filters).forEach(([key, value]) => {
            if (value !== null && value !== undefined && value !== '') parameters.set(key, value);
        });
        window.location.assign(`${root.dataset.exportEndpoint}?${parameters}`);
        status.textContent = 'Excel dengan grafik sedang diunduh.';
    });

    function roundedRect(context, x, y, width, height, radius) {
        context.beginPath();
        context.roundRect(x, y, width, height, radius);
        context.fill();
    }

    function imageFromUrl(source) {
        return new Promise((resolve, reject) => {
            const image = new Image();
            image.onload = () => resolve(image);
            image.onerror = reject;
            image.src = source;
        });
    }

    function fittedText(context, value, maximumWidth, initialSize = 28, minimumSize = 16, weight = 700) {
        const text = String(value ?? 'Belum ada');
        let size = initialSize;
        context.font = `${weight} ${size}px Inter, Arial, sans-serif`;
        while (size > minimumSize && context.measureText(text).width > maximumWidth) {
            size--;
            context.font = `${weight} ${size}px Inter, Arial, sans-serif`;
        }
        if (context.measureText(text).width <= maximumWidth) return text;
        let shortened = text;
        while (shortened.length > 1 && context.measureText(`${shortened}…`).width > maximumWidth) shortened = shortened.slice(0, -1);
        return `${shortened}…`;
    }

    function wrappedText(context, value, x, y, maximumWidth, lineHeight, maximumLines = 2) {
        const words = String(value ?? '').trim().split(/\s+/).filter(Boolean);
        const lines = [];
        let line = '';
        words.forEach(word => {
            const next = line ? `${line} ${word}` : word;
            if (line && context.measureText(next).width > maximumWidth) {
                lines.push(line);
                line = word;
            } else line = next;
        });
        if (line) lines.push(line);
        const visible = lines.slice(0, maximumLines);
        if (lines.length > maximumLines && visible.length) {
            let last = visible[visible.length - 1];
            while (last.length > 1 && context.measureText(`${last}…`).width > maximumWidth) last = last.slice(0, -1);
            visible[visible.length - 1] = `${last}…`;
        }
        visible.forEach((text, index) => context.fillText(text, x, y + index * lineHeight));
    }

    exportImageButton.addEventListener('click', async () => {
        if (!current || exportImageButton.disabled) return;
        const original = exportImageButton.innerHTML;
        exportImageButton.disabled = true;
        exportImageButton.textContent = 'Menyiapkan gambar…';
        error.hidden = true;
        try {
            await document.fonts?.ready;
            const activeTab = tabs.find(tab => tab.getAttribute('aria-selected') === 'true');
            const panel = root.querySelector(`#${activeTab.getAttribute('aria-controls')}`);
            const chartElements = [...panel.querySelectorAll('[data-chart]')];
            const visitorTab = activeTab.dataset.tab === 'visitors';
            const chartImages = await Promise.all(chartElements.map(async (chart, index) => imageFromUrl(await Plotly.toImage(chart, {
                format: 'png', width: visitorTab && index === 0 ? 1600 : 840, height: visitorTab ? 320 : 460, scale: 2,
            }))));

            const canvas = document.createElement('canvas');
            canvas.width = 1920;
            canvas.height = 1080;
            const context = canvas.getContext('2d');
            const activity = activeTab.dataset.tab === 'activity';
            const accent = activity ? palette.brand : visitorTab ? palette.ink : palette.brand;
            const accentText = activity ? palette.brand : visitorTab ? palette.ink : palette.brand;
            const accentSoft = activity || visitorTab ? palette.surface : palette.soft;
            const accentMuted = palette.soft;
            context.fillStyle = palette.surface;
            context.fillRect(0, 0, canvas.width, canvas.height);
            context.fillStyle = accent;
            context.fillRect(0, 0, canvas.width, 164);
            context.fillStyle = palette.surface;
            context.font = '700 42px Inter, Arial, sans-serif';
            context.fillText(`Dasbor ${activeTab.querySelector('strong')?.textContent ?? 'Analitik'}`, 72, 65);
            context.font = '400 23px Inter, Arial, sans-serif';
            context.fillStyle = accentMuted;
            context.fillText(`${dateLabel(current.filters.start_date)} sampai ${dateLabel(current.filters.end_date)}`, 72, 105);
            const activeFilterLabels = ['program_id', 'category', 'payment_status', 'participant_status']
                .filter(key => current.filters[key])
                .map(key => `${labels[key]}: ${selectedLabel(key, current.filters[key])}`);
            context.font = '500 17px Inter, Arial, sans-serif';
            context.fillStyle = palette.surface;
            context.fillText(fittedText(context, activeFilterLabels.length ? `Filter · ${activeFilterLabels.join(' · ')}` : 'Filter · Semua pelatihan dan status', 1220, 17, 14, 500), 72, 140);
            context.textAlign = 'right';
            context.fillStyle = palette.surface;
            context.font = '700 21px Inter, Arial, sans-serif';
            context.fillText('UISI · Pusat Sertifikasi', 1848, 62);
            context.font = '400 16px Inter, Arial, sans-serif';
            context.fillStyle = accentMuted;
            context.fillText(`Diperbarui ${new Date(current.generated_at).toLocaleString('id-ID', {dateStyle:'medium', timeStyle:'short'})}`, 1848, 99);
            context.textAlign = 'left';

            const registrationLeader = [...current.programs]
                .filter(program => program.registrations > 0)
                .sort((a, b) => b.registrations - a.registrations || a.title.localeCompare(b.title))[0];
            const revenueLeader = [...current.programs]
                .filter(program => program.actual_revenue > 0)
                .sort((a, b) => b.actual_revenue - a.actual_revenue || a.title.localeCompare(b.title))[0];
            const metrics = activity
                ? [
                    ['Pelatihan dilaksanakan', number.format(current.summary.conducted_programs)],
                    ['Jumlah pendaftar', `${number.format(current.summary.registrations)} orang`],
                    ['Pendaftar terbanyak', registrationLeader?.title ?? 'Belum ada data'],
                    ['Pendaftar pada pelatihan teratas', registrationLeader ? `${number.format(registrationLeader.registrations)} orang` : 'Belum ada'],
                ]
                : visitorTab ? [
                    ['Pengunjung unik', number.format(current.visitors.total_visitors)],
                    ['Tampilan halaman pelatihan', number.format(current.visitors.training_page_views)],
                    ['Pendaftar dari situs web', `${number.format(current.visitors.website_registrants)} orang`],
                    ['Tingkat konversi', current.visitors.conversion_rate == null ? 'Belum tersedia' : `${number.format(current.visitors.conversion_rate)}%`],
                ] : [
                    ['Total pendapatan', rupiah.format(current.summary.actual_revenue)],
                    ['Pembayaran diterima', `${number.format(current.summary.receipt_count)} transaksi`],
                    ['Pendapatan tertinggi', revenueLeader?.title ?? 'Belum ada data'],
                    ['Nilai pendapatan tertinggi', revenueLeader ? compactRupiah(revenueLeader.actual_revenue) : 'Belum ada'],
                ];
            metrics.forEach(([label, value], index) => {
                const x = 72 + index * 446;
                context.fillStyle = palette.surface;
                roundedRect(context, x, 188, 426, 116, 15);
                context.fillStyle = index === 0 ? accent : palette.line;
                context.fillRect(x, 188, 5, 116);
                context.fillStyle = palette.muted;
                context.font = '600 16px Inter, Arial, sans-serif';
                context.fillText(label, x + 24, 224);
                context.fillStyle = index === 0 ? accentText : palette.ink;
                const valueText = fittedText(context, value, 378, 28, 16);
                context.fillText(valueText, x + 24, 270);
            });

            if (visitorTab) {
                const visitorLayouts = [
                    {x:72, y:330, width:1776, height:330},
                    {x:72, y:676, width:874, height:330},
                    {x:974, y:676, width:874, height:330},
                ];
                chartElements.forEach((chart, index) => {
                    const layout = visitorLayouts[index];
                    if (!layout) return;
                    const {x, y, width, height} = layout;
                    const card = chart.closest('.ana-card');
                    context.fillStyle = palette.surface;
                    roundedRect(context, x, y, width, height, 16);
                    context.fillStyle = accent;
                    context.fillRect(x, y, width, 5);
                    const title = root.querySelector(`#${chart.getAttribute('aria-labelledby')}`)?.textContent ?? 'Grafik';
                    context.fillStyle = palette.ink;
                    context.font = '700 21px Inter, Arial, sans-serif';
                    context.fillText(title, x + 24, y + 39);
                    context.fillStyle = palette.muted;
                    context.font = '400 14px Inter, Arial, sans-serif';
                    context.fillText(fittedText(context, card?.querySelector('.ana-card-heading p')?.textContent ?? '', width - 48, 14, 12, 400), x + 24, y + 64);
                    context.fillStyle = accentSoft;
                    roundedRect(context, x + 20, y + 78, width - 40, 44, 8);
                    context.fillStyle = accentText;
                    context.font = '600 13px Inter, Arial, sans-serif';
                    context.fillText(fittedText(context, card?.querySelector('.ana-chart-insight')?.textContent ?? 'Belum ada ringkasan pada periode ini.', width - 76, 13, 11, 600), x + 38, y + 105);
                    context.drawImage(chartImages[index], x + 16, y + 128, width - 32, height - 174);
                    context.fillStyle = palette.muted;
                    context.font = '500 12px Inter, Arial, sans-serif';
                    const footnote = (card?.querySelector('.ana-chart-footnote')?.textContent ?? '')
                        .replace(/Klik batang.*$/i, '').replace(/\s+/g, ' ').trim();
                    context.fillText(fittedText(context, footnote, width - 48, 12, 10, 500), x + 24, y + height - 18);
                });
            } else {
                const cardWidth = 874;
                chartElements.forEach((chart, index) => {
                    const x = 72 + index * (cardWidth + 28);
                    const card = chart.closest('.ana-card');
                    context.fillStyle = palette.surface;
                    roundedRect(context, x, 330, cardWidth, 676, 18);
                    context.fillStyle = accent;
                    context.fillRect(x, 330, cardWidth, 5);
                    const title = root.querySelector(`#${chart.getAttribute('aria-labelledby')}`)?.textContent ?? 'Grafik';
                    context.fillStyle = palette.ink;
                    context.font = '700 24px Inter, Arial, sans-serif';
                    context.fillText(title, x + 28, 374);
                    context.fillStyle = palette.muted;
                    context.font = '400 16px Inter, Arial, sans-serif';
                    context.fillText(fittedText(context, card?.querySelector('.ana-card-heading p')?.textContent ?? '', cardWidth - 56, 16, 14, 400), x + 28, 404);
                    context.fillStyle = accentSoft;
                    roundedRect(context, x + 24, 422, cardWidth - 48, 62, 10);
                    context.fillStyle = accentText;
                    context.font = '600 15px Inter, Arial, sans-serif';
                    wrappedText(context, card?.querySelector('.ana-chart-insight')?.textContent ?? 'Belum ada ringkasan untuk periode ini.', x + 42, 447, cardWidth - 84, 20, 2);
                    context.drawImage(chartImages[index], x + 17, 492, cardWidth - 34, 440);
                    context.fillStyle = accentText;
                    context.beginPath();
                    context.arc(x + 30, 969, 5, 0, Math.PI * 2);
                    context.fill();
                    context.fillStyle = palette.muted;
                    context.font = '500 14px Inter, Arial, sans-serif';
                    const footnote = (card?.querySelector('.ana-chart-footnote')?.textContent ?? '')
                        .replace(/Klik batang.*$/i, '').replace(/\s+/g, ' ').trim();
                    context.fillText(fittedText(context, footnote, cardWidth - 78, 14, 12, 500), x + 44, 974);
                });
            }

            context.fillStyle = palette.muted;
            context.font = '400 14px Inter, Arial, sans-serif';
            context.fillText(visitorTab
                ? 'Sumber: data sesi situs web dan pendaftaran UISI yang terhubung melalui ID sesi.'
                : 'Sumber: data pendaftaran dan pembayaran UISI. Angka mengikuti filter pada saat gambar diunduh.', 72, 1047);
            context.textAlign = 'right';
            context.fillText('Dasbor Analitik UISI', 1848, 1047);
            context.textAlign = 'left';

            const blob = await new Promise((resolve, reject) => canvas.toBlob(value => value ? resolve(value) : reject(new Error('Canvas tidak dapat dikonversi.')), 'image/png'));
            downloadBlob(blob, `dashboard-${activeTab.dataset.tab}-${current.filters.start_date}-${current.filters.end_date}.png`);
            status.textContent = 'Gambar dasbor berhasil diunduh dan siap dimasukkan ke PowerPoint.';
        } catch (exception) {
            error.textContent = `Gambar dasbor belum dapat dibuat. ${exception.message}`;
            error.hidden = false;
        } finally {
            exportImageButton.innerHTML = original;
            exportImageButton.disabled = results.getAttribute('aria-busy') === 'true' || !current;
        }
    });

    const initialUrl = new URL(window.location.href);
    initialUrl.searchParams.delete('scope');
    window.history.replaceState({}, '', initialUrl);
    const params = initialUrl.searchParams;
    const initial = {...defaults};
    for (const key of fields) if (params.has(key)) initial[key] = params.get(key);
    restore(initial);
    load();
}
