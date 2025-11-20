import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
  stages: [
    { duration: '10s', target: 5 },   // 5 user input barengan
    { duration: '30s', target: 20 },  // 20 user input barengan
    { duration: '10s', target: 0 },
  ],
};

export default function () {
  // GANTI URL INI dengan URL action form input kamu
  // Cara cek: Buka webnya, inspect element formnya, lihat attribute action="..."
  const url = 'http://127.0.0.1:8000/tanah'; 

  // DATA YANG MAU DIINPUT (Sesuaikan nama field dengan name="" di form HTML kamu)
  const payload = {
    nama_pemilik: 'User Test K6 ' + __VU,   // __VU = nomor virtual user
    alamat: 'Jalan Stress Test No. ' + Date.now(),
    luas_tanah: Math.floor(Math.random() * 500), // Angka random
    // tambahkan field lain jika ada yang wajib diisi
  };

  const params = {
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
  };

  // Melakukan POST request
  const res = http.post(url, payload, params);

  check(res, {
    // Biasanya kalau sukses input, Laravel akan Redirect (302) atau OK (200)
    'is status 302 or 200': (r) => r.status === 302 || r.status === 200,
  });

  sleep(1);
}
