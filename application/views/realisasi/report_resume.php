<table style="border-collapse:collapse;" width="100%" align="center" border="0">
    <tr>
        <td style="font-size:14px;" width="20%" align="center"></td>
        <td style="font-size:18px;" width="60%" align="center"><b>RESUME REALISASI DANA <br>PERIODE <?= strtoupper($header['bulan'] . " " . $header['tahun']); ?><br>CABANG <?= strtoupper($header['nm_bu']); ?></b></td>
        <td style="font-size:14px;" width="20%" align="center"></td>
    </tr>
</table>
<br>
<table align='center' border="1" cellspacing="0" width="100%">
    <tr style='font-size: 12px; font-weight: bold;'>
        <td rowspan='2' width="3%" align="center"><b>ACCOUNT</b></td>
        <td rowspan='2' width="30%" align="center"><b>URAIAN</b></td>
        <td colspan='2' width="5%" align="center"><b>MASA I </b></td>
        <td colspan='2' width="5%" align="center"><b>MASA II</b></td>
        <td colspan='2' width="5%" align="center"><b>MASA III</b></td>
        <td colspan='2' width="5%" align="center"><b>TOTAL</b></td>
    </tr>

    <tr>
        <td width="8%" style='font-size:12px;text-align:center;'><strong>PENGAJUAN (Rp.)</td>
        <td width="8%" style='font-size:12px;text-align:center;'><strong>REALISASI (Rp.)</td>
        <td width="8%" style='font-size:12px;text-align:center;'><strong>PENGAJUAN (Rp.)</td>
        <td width="8%" style='font-size:12px;text-align:center;'><strong>REALISASI (Rp.)</td>
        <td width="8%" style='font-size:12px;text-align:center;'><strong>PENGAJUAN (Rp.)</td>
        <td width="8%" style='font-size:12px;text-align:center;'><strong>REALISASI (Rp.)</td>
        <td width="8%" style='font-size:12px;text-align:center;'><strong>PENGAJUAN (Rp.)</td>
        <td width="8%" style='font-size:12px;text-align:center;'><strong>REALISASI (Rp.)</td>
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
        <?php
        $masa_1 = 0;
        $masa_2 = 0;
        $masa_3 = 0;
        foreach ($account as $coa) {
            if ($coa['id_bidang'] == $bid['id_bidang']) { ?>
                <tr>
                    <td><?= $coa['kd_coa'] ?></td>
                    <td><?= $coa['nm_coa'] ?></td>
                    <td align="right"><?= nominal($coa['permohonan_1']) ?></td>
                    <td align="right"><?= nominal($coa['realisasi_1']) ?></td>
                    <td align="right"><?= nominal($coa['permohonan_2']) ?></td>
                    <td align="right"><?= nominal($coa['realisasi_2']) ?></td>
                    <td align="right"><?= nominal($coa['permohonan_3']) ?></td>
                    <td align="right"><?= nominal($coa['realisasi_3']) ?></td>
                    <td align="right"><?= nominal($coa['permohonan_total']) ?></td>
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
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($masa_1); ?></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($header['total_bidang' . $bid['id_bidang'] . '_permohonan2']); ?></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($masa_2); ?></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($header['total_bidang' . $bid['id_bidang'] . '_permohonan3']); ?></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($masa_3); ?></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($header['total_bidang' . $bid['id_bidang'] . '_permohonan1'] + $header['total_bidang' . $bid['id_bidang'] . '_permohonan2'] + $header['total_bidang' . $bid['id_bidang'] . '_permohonan3']); ?></td>
            <td align="right" style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><?= nominal($masa_1 + $masa_2 + $masa_3); ?> <b>(<?= ($masa_1 + $masa_2 + $masa_3)/($header['total_bidang' . $bid['id_bidang'] . '_permohonan1'] + $header['total_bidang' . $bid['id_bidang'] . '_permohonan2'] + $header['total_bidang' . $bid['id_bidang'] . '_permohonan3'])*100 ?>%)</b></td>
        </tr>
        <tr>
            <td></td>
            <td align="right" style='font-size:14px;background-color:#90EE90; padding-top: 5px; padding-bottom: 5px;'><b>MARGIN</b></td>
            <td colspan="2" align="right" style='font-size:14px;background-color:#90EE90; padding-top: 5px; padding-bottom: 5px;'><?= nominal($masa_1 - $header['total_bidang' . $bid['id_bidang'] . '_permohonan1']) ?></td>
            <td colspan="2" align="right" style='font-size:14px;background-color:#90EE90; padding-top: 5px; padding-bottom: 5px;'><?= nominal($masa_2 - $header['total_bidang' . $bid['id_bidang'] . '_permohonan2']) ?></td>
            <td colspan="2" align="right" style='font-size:14px;background-color:#90EE90; padding-top: 5px; padding-bottom: 5px;'><?= nominal($masa_3 - $header['total_bidang' . $bid['id_bidang'] . '_permohonan3']) ?></td>
            <td colspan="2" align="right" style='font-size:14px;background-color:#90EE90; padding-top: 5px; padding-bottom: 5px;'><?= nominal(($masa_1 + $masa_2 + $masa_3) - ($header['total_bidang' . $bid['id_bidang'] . '_permohonan1'] + $header['total_bidang' . $bid['id_bidang'] . '_permohonan2'] + $header['total_bidang' . $bid['id_bidang'] . '_permohonan3'])) ?></td>
        </tr>
    <?php
    } ?>
        <tr>
            <td></td>
            <td align="right" style='font-size:14px;background-color:#b4a7d6; padding-top: 5px; padding-bottom: 5px;'><b>TOTAL</b></td>
            <td colspan="7" align="right" style='font-size:14px;background-color:#b4a7d6; padding-top: 5px; padding-bottom: 5px;'><?= nominal($header['total_anggaran']) ?></td>
            <td align="right" style='font-size:14px;background-color:#b4a7d6; padding-top: 5px; padding-bottom: 5px;'><?= nominal($header['total']) ?> <b>(<?= $header['total']/$header['total_anggaran']*100 ?>%)</b></td>
        </tr>
</table>
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