#include <iostream>
#include <string>
#include <cstdlib> // Required for the system() function

using namespace std;

int main() {
    string student_id;
    string subject_code;
    
    cout << "======================================\n";
    cout << "     SCHOOL APP ENROLLMENT CLIENT     \n";
    cout << "======================================\n\n";

    // 1. Ask the user for the parameters
    cout << "Enter Student ID: ";
    cin >> student_id;
    
    cout << "Enter Subject Code: ";
    cin >> subject_code;

    // 2. Build the curl command string
    // -s hides the progress bar so we only see the JSON response
    // -X POST specifies the request method
    // -d sends the data parameters
    string command = "curl -s -X POST http://localhost/school-app/enroll_student.php "
                     "-d \"student_id=" + student_id + "\" "
                     "-d \"subject_code=" + subject_code + "\"";
    
    // 3. Execute the request
    cout << "\nSending request to server...\n";
    cout << "--------------------------------------\n";
    cout << "API Response:\n";
    
    system(command.c_str());
    
    cout << "\n--------------------------------------\n\n";
    
    system("pause"); // Keeps the console open so you can read the result
    return 0;
}