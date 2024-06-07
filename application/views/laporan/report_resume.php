<table style="border-collapse:collapse;" width="100%" align="center" border="0">
    <tr>
        <td style="font-size:14px;" width="20%" align="center"></td>
        <td style="font-size:18px;" width="60%" align="center"><b>RINCIAN PERMOHONAN DANA <br>PERIODE <?= strtoupper($header['bulan'] . " " . $header['tahun']); ?><br>CABANG <?= strtoupper($header['nm_bu']); ?></b></td>
        <td style="font-size:14px;" width="20%" align="center"></td>
    </tr>
</table>
<br>
<table align='center' border="1" cellspacing="0" width="100%">
    <tr style='font-size: 12px; font-weight: bold;'>
        <td rowspan='2' width="3%" align="center"><b>ACCOUNT</b></td>
        <td rowspan='2' width="40%" align="center"><b>URAIAN</b></td>

        <td colspan='4' width="5%" align="center"><b>NOMINAL ANGGARAN</b></td>
    </tr>

    <tr>
        <td width="15%" style='font-size:12px;text-align:center;'><strong>MASA I</td>
        <td width="15%" style='font-size:12px;text-align:center;'><strong>MASA II</td>
        <td width="15%" style='font-size:12px;text-align:center;'><strong>MASA III</td>
        <td width="15%" style='font-size:12px;text-align:center;'><strong>TOTAL</td>
    </tr>

    <tr style='background-color:#c9c8c7'>
        <td style='font-size:12px;text-align:center;'><strong>1</td>
        <td style='font-size:12px;text-align:center;'><strong>2</td>
        <td style='font-size:12px;text-align:center;'><strong>3</td>
        <td style='font-size:12px;text-align:center;'><strong>4</td>
        <td style='font-size:12px;text-align:center;'><strong>5</td>
        <td style='font-size:12px;text-align:center;'><strong>6</td>
    </tr>

    <?php
    foreach ($bidang as $bid) { ?>
        <tr>
            <td style='font-size:14px;background-color:#a8d2ff; padding-top: 5px; padding-bottom: 5px;' colspan='6'><b><?= $bid['nm_bidang']; ?></b></td>
        </tr>
        <?php foreach ($account as $coa) {
            if ($coa['id_bidang'] == $bid['id_bidang']) { ?>
                <tr>
                    <td><?= $coa['kd_coa'] ?></td>
                    <td><?= $coa['nm_coa'] ?></td>
                    <td>Rp. <?= nominal($coa['permohonan_1']) ?></td>
                    <td>Rp. <?= nominal($coa['permohonan_2']) ?></td>
                    <td>Rp. <?= nominal($coa['permohonan_3']) ?></td>
                    <td>Rp. <?= nominal($coa['permohonan_total']) ?></td>

                </tr>
            <?php } ?>
        <?php } ?>
        <tr>
            <td></td>
            <td style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'><b>TOTAL <?= $bid['nm_bidang']; ?></b></td>
            <td style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'>Rp. <?= nominal($header['total_bidang' . $bid['id_bidang'] . '_permohonan1']); ?></td>
            <td style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'>Rp. <?= nominal($header['total_bidang' . $bid['id_bidang'] . '_permohonan2']); ?></td>
            <td style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'>Rp. <?= nominal($header['total_bidang' . $bid['id_bidang'] . '_permohonan3']); ?></td>
            <td style='font-size:14px;background-color:#FFDD4A; padding-top: 5px; padding-bottom: 5px;'>Rp. <?= nominal($header['total_bidang' . $bid['id_bidang'] . '_permohonan1'] + $header['total_bidang' . $bid['id_bidang'] . '_permohonan2'] + $header['total_bidang' . $bid['id_bidang'] . '_permohonan3']); ?></td>
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