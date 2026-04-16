import requests
import json

def run_client():
    print("======================================")
    print("     SCHOOL APP ENROLLMENT CLIENT     ")
    print("               (Python)               ")
    print("======================================\n")

    # 1. Ask the user for the parameters
    student_id = input("Enter Student ID: ")
    subject_code = input("Enter Subject Code: ")

    # 2. Set up the API endpoint URL and the data payload
    url = "http://localhost/school-app/enroll_student.php"
    payload = {
        "student_id": student_id,
        "subject_code": subject_code
    }

    print("\nSending request to server...")
    print("-" * 38)
    print("API Response:\n")

    try:
        # 3. Execute the POST request
        response = requests.post(url, data=payload)
        
        # 4. Try to format the JSON nicely, otherwise print raw text
        try:
            json_response = response.json()
            print(json.dumps(json_response, indent=4))
        except ValueError:
            print(response.text)
            
    except requests.exceptions.RequestException as e:
        print(f"Failed to connect to the server: {e}")

    print("\n" + "-" * 38 + "\n")

if __name__ == "__main__":
    run_client()