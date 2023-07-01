const { Client } = require('pg')
const client = new Client({
  user: 'sgpostgres',
  host: 'SG-PostgreNoSSL-14-pgsql-master.devservers.scalegrid.io',
  database: 'postgres',
  password: '1t4b1s3br',
  port: 5432,
})
client.connect(function(err) {
  if (err) throw err;
  console.log("Connected!");
});