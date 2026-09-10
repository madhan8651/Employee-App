/*
|--------------------------------------------------------------------------
| EMPLOYEE ID
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| API URL
|--------------------------------------------------------------------------
*/

const apiUrl =
    "/Employee_App/routes/api.php/employees/";


/*
|--------------------------------------------------------------------------
| ELEMENTS
|--------------------------------------------------------------------------
*/

const messageBox =
    document.getElementById("message");

const profilePhoto =
    document.getElementById("profilePhoto");

const profileInitial =
    document.getElementById("profileInitial");


/*
|--------------------------------------------------------------------------
| SHOW MESSAGE
|--------------------------------------------------------------------------
*/

function showMessage(message, success)
{
    messageBox.innerHTML =
        `
        <div class="alert ${success ? "alert-success" : "alert-danger"}">
            ${message}
        </div>
        `;


    setTimeout(function () {

        messageBox.scrollIntoView({
            behavior: "smooth",
            block: "center"
        });

    }, 100);
}


/*
|--------------------------------------------------------------------------
| LOAD EMPLOYEE
|--------------------------------------------------------------------------
*/

async function loadEmployee()
{

    if (!employeeId) {

        showMessage(
            "Employee ID is required.",
            false
        );

        return;
    }


    try {

        const response =
            await fetch(
                apiUrl +
                encodeURIComponent(employeeId)
            );


        const employee =
            await response.json();


        if (!response.ok) {

            showMessage(
                employee.message ||
                "Employee not found.",
                false
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        document.getElementById(
            "profileName"
        ).textContent =
            (employee.first_name || "") +
            " " +
            (employee.last_name || "");


        document.getElementById(
            "profileId"
        ).textContent =
            employee.employee_id || "";


        /*
        |--------------------------------------------------------------------------
        | PROFILE PHOTO
        |--------------------------------------------------------------------------
        */

        if (employee.profile_photo) {

            profilePhoto.src =
                "/Employee_App/public/uploads/employees/" +
                employee.profile_photo;

            profilePhoto.style.display =
                "block";

            profileInitial.style.display =
                "none";

        } else {

            profileInitial.textContent =
                (employee.first_name || "")
                .charAt(0)
                .toUpperCase();

            profileInitial.style.display =
                "block";
        }


        /*
        |--------------------------------------------------------------------------
        | EMPLOYEE DETAILS
        |--------------------------------------------------------------------------
        */

        document.getElementById(
            "employee_id"
        ).textContent =
            employee.employee_id || "";


        document.getElementById(
            "first_name"
        ).textContent =
            employee.first_name || "";


        document.getElementById(
            "last_name"
        ).textContent =
            employee.last_name || "";


        document.getElementById(
            "email"
        ).textContent =
            employee.email || "";


        document.getElementById(
            "phone"
        ).textContent =
            employee.phone || "";


        document.getElementById(
            "date_of_birth"
        ).textContent =
            employee.date_of_birth || "";


        document.getElementById(
            "gender"
        ).textContent =
            employee.gender || "";


        document.getElementById(
            "date_of_joining"
        ).textContent =
            employee.date_of_joining || "";


        document.getElementById(
            "department_id"
        ).textContent =
            employee.department_id || "";


        document.getElementById(
            "designation"
        ).textContent =
            employee.designation || "";


        document.getElementById(
            "salary"
        ).textContent =
            employee.salary ?
            "₹" + employee.salary :
            "";


        document.getElementById(
            "address"
        ).innerHTML =
            (employee.address || "")
            .replace(/\n/g, "<br>");


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        const statusElement =
            document.getElementById("status");


        if (
            (employee.status || "").toLowerCase()
            === "active"
        ) {

            statusElement.textContent =
                "Active";

            statusElement.className =
                "badge bg-success-subtle text-success status-badge";

        } else {

            statusElement.textContent =
                "Inactive";

            statusElement.className =
                "badge bg-secondary-subtle text-secondary status-badge";
        }


        /*
        |--------------------------------------------------------------------------
        | EDIT LINK
        |--------------------------------------------------------------------------
        */

        document.getElementById(
            "editEmployeeLink"
        ).href =
            "edit.php?employee_id=" +
            encodeURIComponent(
                employee.employee_id
            );


    } catch (error) {

        showMessage(
            "Unable to connect to Employee API.",
            false
        );
    }
}


/*
|--------------------------------------------------------------------------
| LOAD EMPLOYEE
|--------------------------------------------------------------------------
*/

loadEmployee();
