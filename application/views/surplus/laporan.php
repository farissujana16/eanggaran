<table style="border-collapse:collapse;" width="100%" align="center" border="0">
    <tr>
        <td style="font-size:14px;" width="20%" align="center"></td>
        <td style="font-size:18px;" width="60%" align="center"><b>LAPORAN SURPLUS/MINUS <br>PERIODE <?= strtoupper($bulan . " " . $tahun); ?><br></b></td>
        <td style="font-size:14px;" width="20%" align="center"></td>
    </tr>
</table>
<br>
<table align='center' border="1" cellspacing="0" width="100%">
    <tr style='font-size: 12px; font-weight: bold;'>
        <td rowspan='2' width="2%" align="center" style="font-size:10px;"><b>No</b></td>
        <td rowspan='2' width="10%" align="center" style="font-size:10px;"><b>CABANG</b></td>
        <td colspan='6' width="22%" align="center" style="font-size:10px;"><b>MASA I </b></td>
        <td colspan='6' width="22%" align="center" style="font-size:10px;"><b>MASA II</b></td>
        <td colspan='6' width="22%" align="center" style="font-size:10px;"><b>MASA III</b></td>
        <td colspan='6' width="22%" align="center" style="font-size:10px;"><b>TOTAL</b></td>
    </tr>

    <tr>
        <td style='font-size:10px;text-align:center;'><strong>PENGAJUAN (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>DROPPING (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>CASH POOLING (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>E-TICKETING (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>SURPLUS/MINUS (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>PERSENTASE</td>
        <td style='font-size:10px;text-align:center;'><strong>PENGAJUAN (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>DROPPING (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>CASH POOLING (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>E-TICKETING (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>SURPLUS/MINUS (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>PERSENTASE</td>
        <td style='font-size:10px;text-align:center;'><strong>PENGAJUAN (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>DROPPING (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>CASH POOLING (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>E-TICKETING (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>SURPLUS/MINUS (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>PERSENTASE</td>
        <td style='font-size:10px;text-align:center;'><strong>PENGAJUAN (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>DROPPING (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>CASH POOLING (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>E-TICKETING (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>SURPLUS/MINUS (Rp.)</td>
        <td style='font-size:10px;text-align:center;'><strong>PERSENTASE</td>
       
    </tr>

    <tr style='background-color:#c9c8c7'>
        <td style='font-size:10px;text-align:center;'><strong>1</td>
        <td style='font-size:10px;text-align:center;'><strong>2</td>
        <td style='font-size:10px;text-align:center;'><strong>3</td>
        <td style='font-size:10px;text-align:center;'><strong>4</td>
        <td style='font-size:10px;text-align:center;'><strong>5</td>
        <td style='font-size:10px;text-align:center;'><strong>6</td>
        <td style='font-size:10px;text-align:center;'><strong>7</td>
        <td style='font-size:10px;text-align:center;'><strong>8</td>
        <td style='font-size:10px;text-align:center;'><strong>9</td>
        <td style='font-size:10px;text-align:center;'><strong>10</td>
        <td style='font-size:10px;text-align:center;'><strong>11</td>
        <td style='font-size:10px;text-align:center;'><strong>12</td>
        <td style='font-size:10px;text-align:center;'><strong>13</td>
        <td style='font-size:10px;text-align:center;'><strong>14</td>
        <td style='font-size:10px;text-align:center;'><strong>15</td>
        <td style='font-size:10px;text-align:center;'><strong>16</td>
        <td style='font-size:10px;text-align:center;'><strong>17</td>
        <td style='font-size:10px;text-align:center;'><strong>18</td>
        <td style='font-size:10px;text-align:center;'><strong>19</td>
        <td style='font-size:10px;text-align:center;'><strong>20</td>
        <td style='font-size:10px;text-align:center;'><strong>21</td>
        <td style='font-size:10px;text-align:center;'><strong>22</td>
        <td style='font-size:10px;text-align:center;'><strong>23</td>
        <td style='font-size:10px;text-align:center;'><strong>24</td>
        <td style='font-size:10px;text-align:center;'><strong>25</td>
        <td style='font-size:10px;text-align:center;'><strong>26</td>
    </tr>
    <?php $no = 1; foreach($surplus as $data): ?>
        <?php
            $total_masa = $data['masa_1'] + $data['masa_2'] + $data['masa_3'];
            $total_drop = $data['drop_1'] + $data['drop_2'] + $data['drop_3'];
            $total_cash = $data['cash_1'] + $data['cash_2'] + $data['cash_3'];
            $total_tiket = $data['tiket_1'] + $data['tiket_2'] + $data['tiket_3'];
            $total_surplus = ($total_cash + $total_tiket) - $total_drop;
            $total_persen = (($total_cash + $total_tiket) / $total_drop) * 100;
        ?>
        <tr>
            <td style='font-size:10px;text-align:center;'><?= $no++ ?></td>
            <td style='font-size:10px;text-align:center;'><?= $data['nm_bu'] ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($data['masa_1']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($data['drop_1']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($data['cash_1']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($data['tiket_1']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal(($data['cash_1'] + $data['tiket_1'])-$data['drop_1']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= (($data['cash_1'] + $data['tiket_1'])/$data['drop_1'])*100 ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($data['masa_2']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($data['drop_2']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($data['cash_2']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($data['tiket_2']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal(($data['cash_2'] + $data['tiket_2'])-$data['drop_2']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= (($data['cash_2'] + $data['tiket_2'])/$data['drop_2'])*100 ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($data['masa_3']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($data['drop_3']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($data['cash_3']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($data['tiket_3']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal(($data['cash_3'] + $data['tiket_3'])-$data['drop_3']) ?></td>
            <td style='font-size:10px;text-align:right;'><?= (($data['cash_3'] + $data['tiket_3'])/$data['drop_3'])*100 ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($total_masa) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($total_drop) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($total_cash) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($total_tiket) ?></td>
            <td style='font-size:10px;text-align:right;'><?= nominal($total_surplus) ?></td>
            <td style='font-size:10px;text-align:right;'><?= $total_persen ?></td>
            
        </tr>
    <?php endforeach ?>
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