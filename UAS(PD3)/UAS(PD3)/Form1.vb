Imports System.Data.SqlClient

Public Class Form1

    Dim koneksi As SqlConnection
    Dim cmd As SqlCommand
    Dim da As SqlDataAdapter
    Dim ds As DataSet

    Sub konek()
        koneksi = New SqlConnection("Data Source=LAPTOP-N8MU1NND;Initial Catalog=DBUASPD3;Integrated Security=True")
        If koneksi.State = ConnectionState.Closed Then
            koneksi.Open()
        End If
    End Sub


    Sub tampil()
        konek()
        da = New SqlDataAdapter("SELECT * FROM tbbarang", koneksi)
        ds = New DataSet
        da.Fill(ds, "tbbarang")
        datagridviewbarang.DataSource = ds.Tables("tbbarang")
    End Sub

    Sub bersih()
        txtkodebarang.Clear()
        txtnamabarang.Clear()
        txthargabeli.Clear()
        txthargajual.Clear()
        txtstok.Clear()
        cbsatuan.Text = ""
        txtkodebarang.Focus()
    End Sub

    Private Sub Form1_Load(ByVal sender As Object, ByVal e As EventArgs) Handles MyBase.Load
        tampil()
        bersih()
    End Sub

    ' ================= SIMPAN =================
    Private Sub btnsimpan_Click(ByVal sender As Object, ByVal e As EventArgs) Handles btnsimpan.Click
        konek()
        cmd = New SqlCommand("INSERT INTO tbbarang (kodebarang,namabarang,satuan,hargabeli,hargajual,stok) VALUES (@kode,@nama,@satuan,@hb,@hj,@stok)", koneksi)

        cmd.Parameters.AddWithValue("@kode", txtkodebarang.Text)
        cmd.Parameters.AddWithValue("@nama", txtnamabarang.Text)
        cmd.Parameters.AddWithValue("@satuan", cbsatuan.Text)
        cmd.Parameters.AddWithValue("@hb", Val(txthargabeli.Text))
        cmd.Parameters.AddWithValue("@hj", Val(txthargajual.Text))
        cmd.Parameters.AddWithValue("@stok", Val(txtstok.Text))

        cmd.ExecuteNonQuery()
        MessageBox.Show("Data berhasil disimpan")
        tampil()
        bersih()
    End Sub

    ' ================= EDIT =================
    Private Sub btnedit_Click(ByVal sender As Object, ByVal e As EventArgs) Handles btnedit.Click
        konek()
        cmd = New SqlCommand("UPDATE tbbarang SET namabarang=@nama,satuan=@satuan,hargabeli=@hb,hargajual=@hj,stok=@stok WHERE kodebarang=@kode", koneksi)

        cmd.Parameters.AddWithValue("@kode", txtkodebarang.Text)
        cmd.Parameters.AddWithValue("@nama", txtnamabarang.Text)
        cmd.Parameters.AddWithValue("@satuan", cbsatuan.Text)
        cmd.Parameters.AddWithValue("@hb", Val(txthargabeli.Text))
        cmd.Parameters.AddWithValue("@hj", Val(txthargajual.Text))
        cmd.Parameters.AddWithValue("@stok", Val(txtstok.Text))

        cmd.ExecuteNonQuery()
        MessageBox.Show("Data berhasil diupdate")
        tampil()
        bersih()
    End Sub

    ' ================= HAPUS =================
    Private Sub btnhapus_Click(ByVal sender As Object, ByVal e As EventArgs) Handles btnhapus.Click
        If MessageBox.Show("Yakin ingin menghapus data?", "Konfirmasi",
                           MessageBoxButtons.YesNo) = DialogResult.Yes Then
            konek()
            cmd = New SqlCommand("DELETE FROM tbbarang WHERE kodebarang=@kode", koneksi)
            cmd.Parameters.AddWithValue("@kode", txtkodebarang.Text)
            cmd.ExecuteNonQuery()

            MessageBox.Show("Data berhasil dihapus")
            tampil()
            bersih()
        End If
    End Sub

    ' ================= KELUAR =================
    Private Sub btnkeluar_Click(ByVal sender As Object, ByVal e As EventArgs) Handles btnkeluar.Click
        Me.Close()
    End Sub

    ' ================= KLIK GRID =================
    Private Sub datagridviewbarang_CellClick(ByVal sender As Object, ByVal e As DataGridViewCellEventArgs) Handles datagridviewbarang.CellClick
        If e.RowIndex >= 0 Then
            txtkodebarang.Text = datagridviewbarang.Rows(e.RowIndex).Cells(0).Value
            txtnamabarang.Text = datagridviewbarang.Rows(e.RowIndex).Cells(1).Value
            cbsatuan.Text = datagridviewbarang.Rows(e.RowIndex).Cells(2).Value
            txthargabeli.Text = datagridviewbarang.Rows(e.RowIndex).Cells(3).Value
            txthargajual.Text = datagridviewbarang.Rows(e.RowIndex).Cells(4).Value
            txtstok.Text = datagridviewbarang.Rows(e.RowIndex).Cells(5).Value
        End If
    End Sub

End Class