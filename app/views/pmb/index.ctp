<div id="content" class="grid_12 alpha">

			<table class="filter" style="width:auto">
				<tr>
					<td>
                        <label for="">Tahun</label>
						<select name="">
                            <option value="">--Semua--</option>
                            <option value="">2005</option>
                            <option value="">2006</option>
                        </select>
					</td>
					<td>
                        <label for="">Gelombang</label>
						<select name="">
                            <option value="">--Semua--</option>
                            <option value="">I</option>
                            <option value="">II</option>
                        </select>
					</td>
					<td>
                        <label for="">Tanggal (datepicker)</label>
                        <input type="text" name="" style="width:60px" maxlength="10" />
					</td>
                    <td>
                        <button type="button">Apply</button>
                    </td>
				</tr>
			</table>

    <div class="box report">
        <div class="spacer">
            <h2>Rekap PMB</h2>
            <h4>Tahun: 2005 &bull; Gelombang: 1 &bull; Tanggal: 4 Juli 2010</h4>
            <strong>Jumlah pendaftar: 87</strong>
        <table class="report">
            <thead>
                <tr>
                <th>No</th>
                <th>Nomor Registrasi</th>
                <th>Nama Mahasiswa</th>
                <th>Uang 1</th>
                <th>Uang 2</th>
                <th>Petugas Penerima</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>1</td><td>1-05-0002</td><td>Andi Subroto</td><td class="ar">Rp 100.000</td><td class="ar">Rp 170.000</td><td>Sukirman</td></tr>
                <tr><td>2</td><td>1-05-0002</td><td>Beni</td><td class="ar">Rp 100.000</td><td class="ar">Rp 170.000</td><td>Sukirman</td></tr>
                <tr><td>3</td><td>1-05-0002</td><td>Cahyana</td><td class="ar">Rp 100.000</td><td class="ar">Rp 170.000</td><td>Sukirman</td></tr>
                <tr><td>4</td><td>1-05-0002</td><td>Duridam Dam</td><td class="ar">Rp 100.000</td><td class="ar">Rp 170.000</td><td>Marwoto</td></tr>
            </tbody>
            <tfoot>
                <tr><th colspan='3' class="ac"><strong>Jumlah</strong></th><th class="ar">Rp 400.000</th><th class="ar">Rp 680.000</th><th>Total uang<div class="total">Rp 1.080.000</div></th></tr>
            </tfootr>
        </table>
        </div>
    </div>
</div>

<div class="grid_4 omega" id="sidebar">
	<div class="special">
		<?php echo $html->link($html->image('pdf.png'). __('Cetak', true), array('action'=>'export', 'pdf'), array('class'=>'tombol'), null, false); ?>
	</div>
</div>
