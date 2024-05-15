const { createConnection } = require("../config/config");
const fs = require('fs/promises')
class Model {
    static async cek(id) {
        try {
            const connection = await createConnection()
            const dataBackup = JSON.parse(await fs.readFile('./data/data.json', 'utf-8'))

            // Mengecek keberadaan ID di tabel nota
            const [notaRows] = await connection.execute('SELECT * FROM nota WHERE ids = ?', [id]);
            if (notaRows.length === 0) {
                throw ('Data not found => nota')
            }
            dataBackup.push({ table: 'nota', data: notaRows });

            // Mengecek keberadaan ID di tabel history_pay
            const [historyPayRows] = await connection.execute('SELECT * FROM history_pay WHERE ids = ?', [id]);
            if (historyPayRows.length === 0) {
                throw ('Data not found => history_pay')
            }
            dataBackup.push({ table: 'history_pay', data: historyPayRows });

            // Mengecek keberadaan ID di tabel payments1
            const [payments1Rows] = await connection.execute('SELECT * FROM payments1 WHERE ids = ?', [id]);
            if (payments1Rows.length === 0) {
                throw ('Data not found => payments1')
            }
            dataBackup.push({ table: 'payments1', data: payments1Rows });

            // Mengecek keberadaan ID di tabel payments2
            const [payments2Rows] = await connection.execute('SELECT * FROM payments2 WHERE ids = ?', [id]);
            if (payments2Rows.length === 0) {
                throw ('Data not found => payments2')
            }
            dataBackup.push({ table: 'payments2', data: payments2Rows });

            await fs.writeFile('./data/data.json', JSON.stringify(dataBackup, null, 2));
            this.delete(id)
            await connection.end();
        } catch (error) {
            console.error('Terjadi kesalahan:', error);
        }
    }

    static async delete(id) {
        try {
            const connection = await createConnection();

            // Menghapus data dari tabel nota
            const [notaResult] = await connection.execute('DELETE FROM nota WHERE ids = ?', [id]);
            if (notaResult.affectedRows === 0) {
                throw new Error('Gagal menghapus data dari tabel nota atau data tidak ditemukan.');
            }
            console.log('Data dari tabel nota telah dihapus.');

            // Menghapus data dari tabel history_pay
            const [historyPayResult] = await connection.execute('DELETE FROM history_pay WHERE ids = ?', [id]);
            if (historyPayResult.affectedRows === 0) {
                throw new Error('Gagal menghapus data dari tabel history_pay atau data tidak ditemukan.');
            }
            console.log('Data dari tabel history_pay telah dihapus.');

            // Menghapus data dari tabel payments1
            const [payments1Result] = await connection.execute('DELETE FROM payments1 WHERE ids = ?', [id]);
            if (payments1Result.affectedRows === 0) {
                throw new Error('Gagal menghapus data dari tabel payments1 atau data tidak ditemukan.');
            }
            console.log('Data dari tabel payments1 telah dihapus.');

            // Menghapus data dari tabel payments2
            const [payments2Result] = await connection.execute('DELETE FROM payments2 WHERE ids = ?', [id]);
            if (payments2Result.affectedRows === 0) {
                throw new Error('Gagal menghapus data dari tabel payments2 atau data tidak ditemukan.');
            }
            console.log('Data dari tabel payments2 telah dihapus.');

            return 'OK'
        } catch (error) {
            throw ('Terjadi kesalahan:', error);
        }
    }

    static async cekData(id) {
        try {
            const connection = await createConnection();
            const [result] = await connection.execute(`select * from santri where ids = ?`, [id])
            console.log(result)
        } catch (error) {
            console.log(error);
        }
    }
}

module.exports = Model