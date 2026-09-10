const API_URL =
    "/Employee_App/routes/api.php/departments";


const departmentDetails =
    document.getElementById("departmentDetails");

const message =
    document.getElementById("message");


/*
|--------------------------------------------------------------------------
| HTML ESCAPE
|--------------------------------------------------------------------------
*/

function escapeHtml(value)
{
    return String(value ?? "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}


/*
|--------------------------------------------------------------------------
| SHOW ERROR MESSAGE
|--------------------------------------------------------------------------
*/

function showError(messageText)
{
    message.innerHTML = `
        <div class="alert alert-danger">
            ${escapeHtml(messageText)}
        </div>
    `;
}


/*
|--------------------------------------------------------------------------
| LOAD DEPARTMENT
|--------------------------------------------------------------------------
*/

async function loadDepartment()
{
    try {

        /*
        |--------------------------------------------------------------------------
        | API REQUEST
        |--------------------------------------------------------------------------
        */

        const response =
            await fetch(
                API_URL +
                "/" +
                encodeURIComponent(departmentId),
                {
                    method: "GET",
                    credentials: "same-origin",
                    headers: {
                        "Accept": "application/json"
                    }
                }
            );


        /*
        |--------------------------------------------------------------------------
        | READ RESPONSE
        |--------------------------------------------------------------------------
        */

        const text =
            await response.text();


        let result;


        try {

            result =
                JSON.parse(text);

        } catch (error) {

            throw new Error(
                "Department API did not return valid JSON."
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CHECK RESPONSE
        |--------------------------------------------------------------------------
        */

        if (!response.ok) {

            throw new Error(
                result.message ||
                "Unable to load department."
            );
        }


        if (!result.success) {

            throw new Error(
                result.message ||
                "Unable to load department."
            );
        }


        /*
        |--------------------------------------------------------------------------
        | GET DATA
        |--------------------------------------------------------------------------
        */

        const department =
            result.data;


        if (!department) {

            throw new Error(
                "Department details not found."
            );
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        const status =
            String(
                department.status || ""
            ).toLowerCase();


        let statusHtml;


        if (status === "active") {

            statusHtml = `
                <span
                    class="badge bg-success-subtle text-success status-badge"
                >
                    Active
                </span>
            `;

        } else {

            statusHtml = `
                <span
                    class="badge bg-secondary-subtle text-secondary status-badge"
                >
                    Inactive
                </span>
            `;
        }


        /*
        |--------------------------------------------------------------------------
        | DISPLAY DEPARTMENT
        |--------------------------------------------------------------------------
        */

        departmentDetails.innerHTML = `

            <div class="department-view-item">

                <span class="department-view-label">
                    Department Name
                </span>

                <div class="department-view-value name">
                    ${escapeHtml(
                        department.department_name
                    )}
                </div>

            </div>


            <div class="department-view-item">

                <span class="department-view-label">
                    Department ID
                </span>

                <div class="department-view-value">
                    ${escapeHtml(
                        department.department_id
                    )}
                </div>

            </div>


            <div class="department-view-item">

                <span class="department-view-label">
                    Description
                </span>

                <div class="department-view-value">
                    ${escapeHtml(
                        department.description || "-"
                    )}
                </div>

            </div>


            <div class="department-view-item">

                <span class="department-view-label">
                    Status
                </span>

                <div class="department-view-value">
                    ${statusHtml}
                </div>

            </div>

        `;


    } catch (error) {

        /*
        |--------------------------------------------------------------------------
        | ERROR HANDLING
        |--------------------------------------------------------------------------
        */

        departmentDetails.innerHTML = `
            <div class="text-center text-danger py-4">
                Unable to load department.
            </div>
        `;


        showError(
            error.message ||
            "Unable to load department."
        );
    }
}


/*
|--------------------------------------------------------------------------
| INITIAL LOAD
|--------------------------------------------------------------------------
*/

loadDepartment();