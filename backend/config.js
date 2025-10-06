import mysql from "mysql2";

const db = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "", // leave blank if you're using XAMPP default
  database: "kultura_db", // create this in phpMyAdmin
  port: 3306,
});

db.connect((err) => {
  if (err) {
    console.error("❌ Database connection failed:", err);
  } else {
    console.log("✅ Connected to local MySQL (localhost)");
  }
});

export default db;
