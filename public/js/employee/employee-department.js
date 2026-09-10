document.addEventListener("DOMContentLoaded", () => {

    const departmentContainer =
        document.getElementById("departmentContainer");

    const message =
        document.getElementById("departmentMessage");

    const backButton =
        document.getElementById("backToProfileButton");


    /*
    |--------------------------------------------------------------------------
    | SHOW MESSAGE
    |--------------------------------------------------------------------------
    */

    function showMessage(text, type = "error") {

        if (!message) {
            return;
        }

        message.textContent =
            text || "Something went wrong.";

        message.className =
            type === "success"
                ? "alert alert-success"
                : "alert alert-danger";

        message.setAttribute(
            "role",
            "alert"
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        if (
            value === null ||
            value === undefined
        ) {
            return "";
        }

        return String(value)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }


    /*
    |--------------------------------------------------------------------------
    | API RESPONSE
    |--------------------------------------------------------------------------
    */

    async function getJsonResponse(response) {

        const text =
            await response.text();

        let data;

        try {

            data =
                JSON.parse(text);

        }
        catch (error) {

            console.error(
                "Server response:",
                text
            );

            throw new Error(
                "Unable to process server response."
            );
        }


        if (
            !response.ok ||
            !data.success
        ) {

            throw new Error(
                data.message ||
                "Request failed. Please try again."
            );
        }


        return data;
    }


    /*
    |--------------------------------------------------------------------------
    | LOADING
    |--------------------------------------------------------------------------
    */

    function showLoading() {

        if (!departmentContainer) {
            return;
        }

        departmentContainer.innerHTML = `

            <div class="department-loading">

                Loading your department information...

            </div>

        `;
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD DEPARTMENT
    |--------------------------------------------------------------------------
    */

    function loadDepartment() {

        showLoading();

        fetch(
            "/Employee_App/routes/api.php/employees/department",
            {
                method: "GET",

                credentials: "same-origin",

                headers: {
                    "Accept": "application/json"
                }
            }
        )

        .then(response => {

            return getJsonResponse(response);

        })

        .then(data => {

            const department =
                data.data;


            /*
            |--------------------------------------------------------------------------
            | DEPARTMENT CONTENT
            |--------------------------------------------------------------------------
            */

            departmentContainer.innerHTML = `

                <div class="department-info-card" style="max-width: 600px; margin: 0 auto;">


                    <!-- =====================================
                         DEPARTMENT HEADER
                    ====================================== -->

                    <div class="department-info-header">

                        <div class="department-info-icon">
                            🏢
                        </div>


                        <h2>
                            ${escapeHtml(
                                department.department_name ||
                                department.department ||
                                "-"
                            )}
                        </h2>


                        <p>
                            Your current department
                        </p>

                    </div>


                    <!-- =====================================
                         DEPARTMENT DETAILS
                    ====================================== -->

                    <div class="department-info-body">


                        <!-- DESIGNATION -->

                        <div class="department-detail-item">

                            <span class="department-detail-label">
                                Your Designation
                            </span>

                            <span class="department-detail-value department-designation">
                                ${escapeHtml(
                                    department.designation ||
                                    "-"
                                )}
                            </span>

                        </div>


                        <!-- EMPLOYEE COUNT -->

                        <div class="department-detail-item">

                            <span class="department-detail-label">
                                Employees in Department
                            </span>

                            <span class="department-detail-value department-employee-count">
                                ${escapeHtml(
                                    department.employee_count ??
                                    department.department_employee_count ??
                                    "0"
                                )}
                            </span>

                        </div>


                        <!-- DESCRIPTION -->

                        <div class="department-detail-item department-description">

                            <span class="department-detail-label">
                                Department Description
                            </span>

                            <span class="department-detail-value">
                                ${escapeHtml(
                                    department.description ||
                                    department.department_description ||
                                    "No description available."
                                )}
                            </span>

                        </div>


                    </div>

                </div>

            `;

        })

        .catch(error => {

            console.error(
                "Department load error:",
                error
            );


            departmentContainer.innerHTML = `

                <div class="department-empty">

                    <div class="department-empty-icon">
                        🏢
                    </div>

                    <h3>
                        Unable to Load Department
                    </h3>

                    <p>
                        ${escapeHtml(
                            error.message ||
                            "Please try again later."
                        )}
                    </p>

                </div>

            `;


            showMessage(
                error.message ||
                "Unable to load your department.",
                "error"
            );

        });
    }


    /*
    |--------------------------------------------------------------------------
    | BACK TO PROFILE
    |--------------------------------------------------------------------------
    */

    if (backButton) {

    backButton.addEventListener("click", () => {

        window.location.href =
            "/Employee_App/routes/auth.php/employees/profile";

    });

}


    /*
    |--------------------------------------------------------------------------
    | INITIAL LOAD
    |--------------------------------------------------------------------------
    */

    loadDepartment();

});