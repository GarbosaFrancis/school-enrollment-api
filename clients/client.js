const axios = require("axios");
const readline = require("readline");

// FIXED: PHP API (NOT 127.0.0.1:5000)
const BASE_URL = "http://localhost/school-app/api";

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

function askQuestion(query) {
  return new Promise(resolve => rl.question(query, resolve));
}

async function getStudents() {
  try {
    const res = await axios.get(`${BASE_URL}/students.php`);

    console.log("\n=== STUDENTS ===");
    res.data.forEach(s => {
      console.log(`${s.student_id} | ${s.full_name} | ${s.program}`);
    });

  } catch (error) {
    console.error("Error fetching students:", error.message);
  }
}

async function getEnrollments() {
  try {
    const res = await axios.get(`${BASE_URL}/enrollments.php`);

    console.log("\n=== ENROLLMENTS ===");
    res.data.forEach(e => {
      console.log(`${e.student_id} -> ${e.subject_code}`);
    });

  } catch (error) {
    console.error("Error fetching enrollments:", error.message);
  }
}

async function run() {
  console.log("📡 Connecting to PHP API...\n");

  await getStudents();
  await getEnrollments();

  const id = await askQuestion("\nEnter Student ID: ");
  const subject = await askQuestion("Enter Subject Code: ");

  console.log(`\n👉 You entered: ${id} - ${subject}`);

  rl.close();
}

run();