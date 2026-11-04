"""Compare PHP hosting results with the original Python engine, including charts."""

import json
import math
from pathlib import Path
import random
import subprocess
import unittest

from dashboard import calculate

ROOT = Path(__file__).resolve().parent.parent


class PhpParityTest(unittest.TestCase):
    def compare(self, expected, actual, path='result'):
        if isinstance(expected, dict):
            self.assertIsInstance(actual, dict, path)
            self.assertEqual(set(expected), set(actual), path)
            for key in expected:
                self.compare(expected[key], actual[key], f'{path}.{key}')
        elif isinstance(expected, list):
            self.assertIsInstance(actual, list, path)
            self.assertEqual(len(expected), len(actual), path)
            for i, value in enumerate(expected):
                self.compare(value, actual[i], f'{path}[{i}]')
        elif isinstance(expected, (int, float)) and not isinstance(expected, bool):
            self.assertTrue(isinstance(actual, (int, float)) and math.isclose(expected, actual, rel_tol=1e-12, abs_tol=1e-12), f'{path}: {expected!r} != {actual!r}')
        else:
            self.assertEqual(expected, actual, path)

    def test_php_preserves_python_figures_and_all_metrics(self):
        rng = random.Random(19092026)
        for scenario in range(18):
            interval = ['day', 'week', 'month'][scenario % 3]
            payload = {
                'filters': {'start_date': '2024-02-28', 'end_date': '2024-03-05', 'interval': interval},
                'programs': [], 'registrations': [], 'receipts': [], 'missing_receipts': [],
            }
            for i in range(0 if scenario < 3 else 8):
                capacity = rng.choice([0, 5, 16, 20, 100])
                payload['programs'].append({'id': i + 1, 'title': ["<b>Same & 'quoted'</b>", 'Bahasa 日本語', 'Program A'][i % 3], 'category': 'pelatihan', 'price': 250000, 'total_quota': capacity, 'quota': rng.randint(-2, capacity + 2)})
                for j in range(4):
                    day = ['2024-02-27', '2024-02-29', '2024-03-05', '2024-03-06'][j]
                    payload['registrations'].append({'program_id': i + 1, 'registration_date': day, 'payment_status': rng.choice(['disetujui', 'menunggu_verifikasi', 'ditolak', 'legacy']), 'participant_status': rng.choice(['diterima', 'diproses', 'legacy']), 'total': rng.randint(0, 20)})
                    if scenario % 4:
                        payload['receipts'].append({'program_id': i + 1, 'received_date': day, 'amount': rng.choice([0, 1500, 250000, 1750000, 2500000000]), 'total': rng.randint(1, 4), 'legacy_dates': rng.randint(0, 1)})
                if i % 2:
                    payload['missing_receipts'].append({'program_id': i + 1, 'total': 2})
            result = subprocess.run(['php', str(ROOT / 'tests/Support/calculate-php-analytics.php')], input=json.dumps(payload), capture_output=True, text=True, encoding='utf-8', check=True)
            with self.subTest(scenario=scenario, interval=interval):
                self.compare(calculate(payload), json.loads(result.stdout))


if __name__ == '__main__':
    unittest.main()
