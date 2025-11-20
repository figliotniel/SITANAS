import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
  // Skenario Edge: Lonjakan tiba-tiba (Spike)
  stages: [
    { duration: '5s', target: 10 },   // Mulai santai
    { duration: '1m', target: 300 },  // BOOM! Langsung 300 user (Overload)
    { duration: '30s', target: 300 }, // Tahan sebentar
    { duration: '10s', target: 0 },   // Selesai
  ],
};

export default function () {
  const res = http.get('http://127.0.0.1:8000/login'); 

  check(res, {
    'status is 200': (r) => r.status === 200,
  });
}
