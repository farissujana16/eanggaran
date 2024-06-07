<table style="border-collapse:collapse;" width="100%" align="center" border="0">
    <tr>
        <td style="font-size:14px;" width="20%" align="center"></td>
        <td style="font-size:18px;" width="60%" align="center"><b>RINCIAN REALISASI DANA <br>PERIODE <?= strtoupper($header['bulan'] . " " . $header['tahun']); ?><br>CABANG <?= strtoupper($header['nm_bu']); ?></b></td>
        <td style="font-size:14px;" width="20%" align="center"></td>
    </tr>
</table>
<br>
<table align='center' border="1" cellspacing="0" width="100%">
    <tr style='font-size: 12px; font-weight: bold;'>
        <td rowspan='2' width="3%" align="center"><b>ACCOUNT</b></td>
        <td rowspan='2' width="50%" align="center"><b>URAIAN</b></td>
        <td colspan='4' width="5%" align="center"><b>PENGAJUAN (Rp.)</b></td>
        <td colspan='4' width="5%" align="center"><b>REALISASI (Rp.)</b></td>
    </tr>

    <tr>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>MASA I</td>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>MASA II</td>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>MASA III</td>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>TOTAL</td>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>MASA I</td>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>MASA II</td>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>MASA III</td>
        <td width="10%" style='font-size:12px;text-align:center;'><strong>TOTAL</td>
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
        <?php $masa_1 = 0;
        $masa_2 = 0;
        $masa_3 = 0;
        foreach ($account as $coa) {
            if ($coa['id_bidang'] == $bid['id_bidang']) { ?>
                <tr>
                    <td><?= $coa['kd_coa'] ?></td>
                    <td><?= $coa['nm_coa'] ?></td>
                    <td align="right"><?= nominal($coa['permohonan_1']) ?></td>
                    <td align="right"><?= nominal($coa['permohonan_2']) ?></td>
                    <td align="right"><?= nominal($coa['permohonan_3']) ?></td>
                    <td align="right"><?= nominal($coa['permohonan_total']) ?></td>
                    <td align="right"><?= nominal($coa['realisasi_1']) ?></td>
                    <td align="right"><?= nominal($coa['realisasi_2']) ?></td>
                    <td align="right"><?= nominal($coa['realisasi_3']) ?></td>
                    <td align="right"><?= nominal($coa['realisasi_total']) ?></td>

                </tr>
            <?php
                $masa_1 += $coa['realisasi_1'];
                $masa_2 += $coa['realisasi_2'];
                $masa_3 += $coa['realisasi_3'];
            } ?>
        <?php } ?>
        <tr>
            <td></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><b>TOTAL <?= $bid['nm_bidang']; ?></b></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($header['total_bidang' . $bid['id_bidang'] . '_permohonan1']); ?></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($header['total_bidang' . $bid['id_bidang'] . '_permohonan2']); ?></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($header['total_bidang' . $bid['id_bidang'] . '_permohonan3']); ?></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($header['total_bidang' . $bid['id_bidang'] . '_permohonan1'] + $header['total_bidang' . $bid['id_bidang'] . '_permohonan2'] + $header['total_bidang' . $bid['id_bidang'] . '_permohonan3']); ?></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($masa_1); ?></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($masa_2); ?></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($masa_3); ?></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($masa_1 + $masa_2 + $masa_3); ?></td>
        </tr>
    <?php
    } ?>


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