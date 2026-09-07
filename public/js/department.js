/*
|--------------------------------------------------------------------------
| API
|--------------------------------------------------------------------------
*/

const API_URL =
    "/Employee_App/routes/api.php/departments";


/*
|--------------------------------------------------------------------------
| Elements
|--------------------------------------------------------------------------
*/

const departmentTableBody =
    document.getElementById(
        "departmentTableBody"
    );

const departmentCount =
    document.getElementById(
        "departmentCount"
    );

const messageBox =
    document.getElementById(
        "message"
    );

const searchInput =
    document.getElementById(
        "searchDepartment"
    );

const statusSelect =
    document.getElementById(
        "statusFilter"
    );

const searchForm =
    document.getElementById(
        "searchForm"
    );

const resetButton =
    document.getElementById(
        "resetButton"
    );


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
            ${escapeHtml(message)}
        </div>
        `;
}


/*
|--------------------------------------------------------------------------
| LOAD DEPARTMENTS
|--------------------------------------------------------------------------
*/

async function loadDepartments()
{
    departmentTableBody.innerHTML =
        `
        <tr>
            <td
                colspan="4"
                class="empty-state"
            >
                Loading departments...
            </td>
        </tr>
        `;


    const params =
        new URLSearchParams();


    const search =
        searchInput.value.trim();

    const status =
        statusSelect.value;


    if (search !== "") {

        params.append(
            "search",
            search
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GET DEPARTMENTS
    |--------------------------------------------------------------------------
    */

    try {

        const response =
            await fetch(
                API_URL +
                "?" +
                params.toString(),
                {
                    method: "GET",
                    credentials: "same-origin"
                }
            );


        const result =
            await response.json();


        if (!response.ok) {

            throw new Error(
                result.message ||
                "Failed to load departments."
            );
        }


        let departments =
            result.data || [];


        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if (status !== "") {

            departments =
                departments.filter(
                    function (department)
                    {
                        return (
                            department.status ===
                            status
                        );
                    }
                );
        }


        /*
        |--------------------------------------------------------------------------
        | DISPLAY DEPARTMENTS
        |--------------------------------------------------------------------------
        */

        departmentTableBody.innerHTML = "";


        if (departments.length === 0) {

            departmentTableBody.innerHTML =
                `
                <tr>
                    <td
                        colspan="4"
                        class="empty-state"
                    >
                        No departments found.
                    </td>
                </tr>
                `;

        } else {

            departments.forEach(
                function (department)
                {

                    const row =
                        document.createElement("tr");


                    const firstInitial =
                        (
                            department.department_name ||
                            ""
                        )
                        .charAt(0)
                        .toUpperCase();


                    const statusValue =
                        (
                            department.status ||
                            ""
                        )
                        .toLowerCase();


                    const statusHtml =
                        statusValue === "active"

                        ?

                        `
                        <span
                            class="badge bg-success-subtle text-success status-badge"
                        >
                            Active
                        </span>
                        `

                        :

                        `
                        <span
                            class="badge bg-secondary-subtle text-secondary status-badge"
                        >
                            Inactive
                        </span>
                        `;


                    row.innerHTML =
                        `
                        <td>

                            <div class="employee-info">

                                <div class="employee-avatar">
                                    ${escapeHtml(firstInitial)}
                                </div>

                                <div>

                                    <div class="employee-name">
                                        ${escapeHtml(
                                            department.department_name || ""
                                        )}
                                    </div>

                                    <div class="employee-id">
                                        Department ID:
                                        ${escapeHtml(
                                            department.department_id || ""
                                        )}
                                    </div>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="designation">
                                ${escapeHtml(
                                    department.description || "-"
                                )}
                            </span>

                        </td>


                        <td>

                            ${statusHtml}

                        </td>


                        <td class="text-end">

                            <a
                                href="view.php?department_id=${encodeURIComponent(
                                    department.department_id
                                )}"
                                class="action-btn me-1"
                                title="View Department"
                            >
                                👁
                            </a>


                            <a
                                href="edit.php?department_id=${encodeURIComponent(
                                    department.department_id
                                )}"
                                class="action-btn"
                                title="Edit Department"
                            >
                                ✎
                            </a>


                            ${
                                statusValue === "active"

                                ?

                                `
                                <a
                                    href="deactivate.php?department_id=${encodeURIComponent(
                                        department.department_id
                                    )}"
                                    class="action-btn"
                                    title="Deactivate Department"
                                    onclick="return confirm('Are you sure you want to deactivate this department?');"
                                >
                                    ⏸
                                </a>
                                `

                                :

                                ""
                            }

                        </td>
                        `;


                    departmentTableBody.appendChild(
                        row
                    );

                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | COUNT
        |--------------------------------------------------------------------------
        */

        departmentCount.innerHTML =
            `
            Showing
            <strong>
                ${departments.length}
            </strong>
            department(s)
            `;


    } catch (error) {

        departmentTableBody.innerHTML =
            `
            <tr>
                <td
                    colspan="4"
                    class="empty-state"
                >
                    Unable to load departments.
                </td>
            </tr>
            `;


        showMessage(
            error.message ||
            "Unable to connect to Department API.",
            false
        );
    }
}


/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

searchForm.addEventListener(
    "submit",
    function (event)
    {
        event.preventDefault();

        loadDepartments();
    }
);


/*
|--------------------------------------------------------------------------
| STATUS
|--------------------------------------------------------------------------
*/

statusSelect.addEventListener(
    "change",
    function ()
    {
        loadDepartments();
    }
);


/*
|--------------------------------------------------------------------------
| RESET
|--------------------------------------------------------------------------
*/

resetButton.addEventListener(
    "click",
    function ()
    {
        searchInput.value = "";
        statusSelect.value = "";

        messageBox.innerHTML = "";

        loadDepartments();
    }
);


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
| INITIAL LOAD
|--------------------------------------------------------------------------
*/

loadDepartments();