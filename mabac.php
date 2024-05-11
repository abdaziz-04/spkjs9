<?php
// Fungsi untuk menghitung bobot relatif
function hitungBobotRelatif($bobotKriteria) {
    $totalBobot = array_sum($bobotKriteria);
    $bobotRelatif = array_map(function($bobot) use ($totalBobot) {
        return $bobot / $totalBobot;
    }, $bobotKriteria);
    return $bobotRelatif;
}

// Fungsi untuk menghitung Preferensi Relatif (PR)
function hitungPR($nilaiAlternatif, $nilaiTerbaik) {
    return $nilaiTerbaik / $nilaiAlternatif;
}

// Fungsi untuk menghitung Preferensi Relatif Terbobot (PRB)
function hitungPRB($pr, $bobotRelatif) {
    return $pr * $bobotRelatif;
}

// Fungsi untuk menghitung Skor Akhir
function hitungSkorAkhir($prbList) {
    return array_sum($prbList);
}

// Data dari matriks keputusan
$data = [
    'D1' => [90, 81, 89, 77],
    'D2' => [70, 80, 80, 85],
    'D3' => [85, 69, 78, 80],
    'D4' => [95, 80, 83, 80],
    'D5' => [82, 75, 85, 82],
    'D6' => [76, 85, 80, 87],
    'D7' => [72, 80, 75, 78],
    'D8' => [68, 72, 79, 86]
];

// Kode kriteria dan bobot
$kriteria = ['C1', 'C2', 'C3', 'C4'];
$bobotKriteria = [25, 30, 25, 20];

// Hitung bobot relatif
$bobotRelatif = hitungBobotRelatif($bobotKriteria);

// Hitung nilai PR, PRB, dan Skor Akhir untuk setiap desa
$skorAkhir = [];
foreach ($data as $desa => $nilaiKriteria) {
    $prList = array_map(function($nilai) use ($nilaiKriteria) {
        return hitungPR($nilai, max($nilaiKriteria));
    }, $nilaiKriteria);
    $prbList = array_map(function($pr, $bobot) {
        return hitungPRB($pr, $bobot);
    }, $prList, $bobotRelatif);
    $skorAkhir[$desa] = hitungSkorAkhir($prbList);
}

// Urutkan desa berdasarkan Skor Akhir
arsort($skorAkhir);

// Tampilkan peringkat desa
echo "Peringkat Desa:\n";
$i = 1;
foreach ($skorAkhir as $desa => $skor) {
    echo "$i. $desa: Skor Akhir = $skor\n";
    $i++;
}
?>
