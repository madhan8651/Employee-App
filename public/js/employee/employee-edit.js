
/*
|--------------------------------------------------------------------------
| API URL
|--------------------------------------------------------------------------
*/
const apiUrl =
    "/Employee_App/routes/api.php/employees/";


/*
|--------------------------------------------------------------------------
| Elements
|--------------------------------------------------------------------------
*/

const employeeForm =
    document.getElementById("editEmployeeForm");

const messageBox =
    document.getElementById("message");

const updateButton =
    document.getElementById("updateButton");


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
        | FILL FORM
        |--------------------------------------------------------------------------
        */

        document.getElementById(
            "employee_id_display"
        ).value =
            employee.employee_id;


        document.getElementById(
            "employee_id"
        ).value =
            employee.employee_id;


        document.getElementById(
            "first_name"
        ).value =
            employee.first_name || "";


        document.getElementById(
            "last_name"
        ).value =
            employee.last_name || "";


        document.getElementById(
            "email"
        ).value =
            employee.email || "";


        document.getElementById(
            "phone"
        ).value =
            employee.phone || "";


        document.getElementById(
            "date_of_birth"
        ).value =
            employee.date_of_birth || "";


        document.getElementById(
            "gender"
        ).value =
            employee.gender || "";


        document.getElementById(
            "date_of_joining"
        ).value =
            employee.date_of_joining || "";


        document.getElementById(
            "department_id"
        ).value =
            employee.department_id || "";


        document.getElementById(
            "designation"
        ).value =
            employee.designation || "";


        document.getElementById(
            "salary"
        ).value =
            employee.salary || "";


        document.getElementById(
            "status"
        ).value =
            (employee.status || "").toLowerCase();


        document.getElementById(
            "address"
        ).value =
            employee.address || "";


        /*
        |--------------------------------------------------------------------------
        | CURRENT PROFILE PHOTO
        |--------------------------------------------------------------------------
        */

        if (employee.profile_photo) {

            document.getElementById(
                "currentPhoto"
            ).textContent =
                "Current profile photo: " +
                employee.profile_photo;

        }

    } catch (error) {

        showMessage(
            "Unable to connect to Employee API.",
            false
        );
    }
}


/*
|--------------------------------------------------------------------------
| UPDATE EMPLOYEE
|--------------------------------------------------------------------------
*/

employeeForm.addEventListener(
    "submit",
    async function (event)
    {

        event.preventDefault();


        const formData =
            new FormData(employeeForm);


        updateButton.disabled = true;

        updateButton.textContent =
            "Updating...";


        try {

            const response =
                await fetch(
                    apiUrl +
                    encodeURIComponent(employeeId),
                    {
                        method: "POST",

                        headers: {
                            "X-HTTP-Method-Override": "PUT"
                        },

                        credentials: "same-origin",

                        body: formData
                    }
                );


            const result =
                await response.json();


            showMessage(
                result.message ||
                "Unable to update employee.",
                result.success
            );


        } catch (error) {

            showMessage(
                "Unable to connect to Employee API.",
                false
            );

        } finally {

            updateButton.disabled = false;

            updateButton.textContent =
                "Update Employee";
        }

    }
);


/*
|--------------------------------------------------------------------------
| LOAD EMPLOYEE WHEN PAGE OPENS
|--------------------------------------------------------------------------
*/

loadEmployee();