const mysql = require('mysql2/promise');

const connectionConfig = ({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'pondok_lama'
});

// const connectionConfig = ({
//     host: '153.92.13.204',
//     user: 'u462981871_pondok',
//     password: 'Norali12',
//     database: 'u462981871_pondokku'
// });

async function createConnection() {
    try {
        const connection = await mysql.createConnection(connectionConfig);
        // console.log('Koneksi ke database berhasil!');
        return connection;
    } catch (error) {
        // console.error('Gagal terhubung ke database:', error.message);
        throw error;
    }
}

module.exports = { createConnection }