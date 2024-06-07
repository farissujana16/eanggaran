<table style="border-collapse:collapse;" width="100%" align="center" border="0">
    <tr>
        <td style="font-size:14px;" width="20%" align="center"></td>
        <td style="font-size:18px;" width="60%" align="center"><b>RINCIAN PERBAIKAN PERMOHONAN DANA <br>PERIODE <?= strtoupper($header['bulan'] . " " . $header['tahun']); ?><br>CABANG <?= strtoupper($header['nm_bu']); ?></b></td>
        <td style="font-size:14px;" width="20%" align="center"></td>
    </tr>
</table>
<br>
<table align='center' border="1" cellspacing="0" width="100%">
    <tr style='font-size: 12px; font-weight: bold;'>
        <td rowspan='2' width="3%" align="center"><b>ACCOUNT</b></td>
        <td rowspan='2' width="50%" align="center"><b>URAIAN</b></td>
        <td colspan='4' width="5%" align="center"><b>NOMINAL ANGGARAN</b></td>
        <td colspan='4' width="5%" align="center"><b>NOMINAL PEERBAIKAN</b></td>
    </tr>

    <tr>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>MASA I (Rp.)</td>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>MASA II (Rp.)</td>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>MASA III (Rp.)</td>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>TOTAL (Rp.)</td>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>MASA I (Rp.)</td>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>MASA II (Rp.)</td>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>MASA III (Rp.)</td>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>TOTAL (Rp.)</td>
    </tr>

    <tr style='background-color:#c9c8c7'>
        <td style='font-size:12px;text-align:center;'><strong>1</td>
        <td style='font-size:12px;text-align:center;'><strong>2</td>
        <td style='font-size:12px;text-align:center;'><strong>3</td>
        <td style='font-size:12px;text-align:center;'><strong>4</td>
        <td style='font-size:12px;text-align:center;'><strong>5</td>
        <td style='font-size:12px;text-align:center;'><strong>6</td>
        <td style='font-size:12px;text-align:center;'><strong>7</td>
        <td style='font-size:12px;text-align:center;'><strong>8</td>
        <td style='font-size:12px;text-align:center;'><strong>9</td>
        <td style='font-size:12px;text-align:center;'><strong>10</td>
    </tr>

    <?php
    foreach ($bidang as $bid) { ?>
        <tr>
            <td style='font-size:14px;background-color:#a8d2ff; padding-top: 5px; padding-bottom: 5px;' colspan='10'><b><?= $bid['nm_bidang']; ?></b></td>
        </tr>
        <?php foreach ($account as $coa) {
            if ($coa['id_bidang'] == $bid['id_bidang']) { ?>
                <tr>
                    <td><?= $coa['kd_coa'] ?></td>
                    <td><?= $coa['nm_coa'] ?></td>
                    <td><?= nominal($coa['permohonan_1']) ?></td>
                    <td><?= nominal($coa['permohonan_2']) ?></td>
                    <td><?= nominal($coa['permohonan_3']) ?></td>
                    <td><?= nominal($coa['permohonan_1'] + $coa['permohonan_2'] + $coa['permohonan_3']) ?></td>
                    <td><?= nominal($coa['perbaikan_1']) ?></td>
                    <td><?= nominal($coa['perbaikan_2']) ?></td>
                    <td><?= nominal($coa['perbaikan_3']) ?></td>
                    <td><?= nominal($coa['perbaikan_1'] + $coa['perbaikan_2'] + $coa['perbaikan_3']) ?></td>
                <?php } ?>
            <?php } ?>

        <?php } ?>
        <?php

        function hari($tanggal)
        {
            $day = date('D', strtotime($tanggal));
            $dayList = array(
                'Sun' => 'Minggu',
                'Mon' => 'Senin',
                'Tue' => 'Selasa',
                'Wed' => 'Rabu',
                'Thu' => 'Kamis',
                'Fri' => 'Jumat',
                'Sat' => 'Sabtu'
            );
            return $dayList[$day];
        }

        function nominal($nilai)
        {
            return number_format($nilai, 2, ',', '.');
        }

        ?>