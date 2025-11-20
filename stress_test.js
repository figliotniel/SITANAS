import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
  // Skenario Stress: Naik perlahan sampai beban tinggi
  stages: [
    { duration: '10s', target: 10 },  // Pemanasan
    { duration: '30s', target: 50 },  // Beban Normal
    { duration: '1m', target: 150 },  // Beban STRESS (Cari break point disini)
    { duration: '10s', target: 0 },   // Pendinginan
  ],
  thresholds: {
    http_req_duration: ['p(95)<2000'], // Target: 95% request harus dibawah 2 detik
    http_req_failed: ['rate<0.05'],    // Target: Error rate dibawah 5%
  },
};

export default function () {
  // Pastikan server Laravel (php artisan serve) sudah jalan
  const res = http.get('http://127.0.0.1:8000/login'); 

  check(res, {
    'status is 200': (r) => r.status === 200,
  });

  sleep(1);
}
