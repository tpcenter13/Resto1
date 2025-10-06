import express from "express";
import cors from "cors";
import bodyParser from "body-parser";
import db from "./config.js";
import bcrypt from "bcrypt";

const app = express();
app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// 📝 SIGNUP
app.post("/signup", async (req, res) => {
  const { fullname, email, password } = req.body;

  if (!fullname || !email || !password) {
    return res.status(400).json({ message: "All fields are required" });
  }

  try {
    const hashedPassword = await bcrypt.hash(password, 10);
    const sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
    db.query(sql, [fullname, email, hashedPassword], (err) => {
      if (err) {
        console.error(err);
        return res.status(400).json({ message: "Email already exists or error occurred" });
      }
      res.status(201).json({ message: "Account created successfully!" });
    });
  } catch (error) {
    res.status(500).json({ message: "Server error" });
  }
});

// 🔐 LOGIN
app.post("/login", (req, res) => {
  const { email, password } = req.body;

  const sql = "SELECT * FROM users WHERE email = ?";
  db.query(sql, [email], async (err, result) => {
    if (err) return res.status(500).json({ message: "Database error" });

    if (result.length === 0)
      return res.status(404).json({ message: "User not found" });

    const user = result[0];
    const isMatch = await bcrypt.compare(password, user.password);

    if (!isMatch) return res.status(401).json({ message: "Invalid password" });

    res.status(200).json({ message: "Login successful", fullname: user.fullname });
  });
});

app.listen(3000, () => console.log("🚀 Server running at http://localhost:3000"));
