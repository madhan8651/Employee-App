/*
|--------------------------------------------------------------------------
| API
|--------------------------------------------------------------------------
*/

const API_URL =
    "/Employee_App/routes/api.php/employees";


/*
|--------------------------------------------------------------------------
| Current Page
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Elements
|--------------------------------------------------------------------------
*/

const employeeTableBody =
    document.getElementById(
        "employeeTableBody"
    );

const employeeCount =
    document.getElementById(
        "employeeCount"
    );

const pagination =
    document.getElementById(
        "pagination"
    );

const messageBox =
    document.getElementById(
        "message"
    );

const searchInput =
    document.getElementById(
        "search"
    );

const departmentSelect =
    document.getElementById(
        "department_id"
    );

const statusSelect =
    document.getElementById(
        "status"
    );

const sortSelect =
    document.getElementById(
        "sort"
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
            ${message}
        </div>
        `;

    setTimeout(
        function ()
        {
            messageBox.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });
        },
        100
    );
}


/*
|--------------------------------------------------------------------------
| LOAD EMPLOYEES
|--------------------------------------------------------------------------
*/

async function loadEmployees()
{

    employeeTableBody.innerHTML =
        `
        <tr>
            <td
                colspan="8"
                class="empty-state"
            >
                Loading employees...
            </td>
        </tr>
        `;


    const params =
        new URLSearchParams();


    const search =
        searchInput.value.trim();

    const departmentId =
        departmentSelect.value;

    const status =
        statusSelect.value;

    const sort =
        sortSelect.value;


    if (search !== "") {
        params.append(
            "search",
            search
        );
    }


    if (departmentId !== "") {
        params.append(
            "department_id",
            departmentId
        );
    }


    if (status !== "") {
        params.append(
            "status",
            status
        );
    }


    if (sort !== "") {
        params.append(
            "sort",
            sort
        );
    }


    params.append(
        "page",
        currentPage
    );


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
                "Failed to load employees."
            );
        }


        const employees =
            result.data || [];

        const pageData =
            result.pagination || {};


        /*
        |--------------------------------------------------------------------------
        | DISPLAY EMPLOYEES
        |--------------------------------------------------------------------------
        */

        employeeTableBody.innerHTML = "";


        if (employees.length === 0) {

            employeeTableBody.innerHTML =
                `
                <tr>
                    <td
                        colspan="8"
                        class="empty-state"
                    >
                        No employees found.
                    </td>
                </tr>
                `;

        } else {

            employees.forEach(
                function (employee)
                {

                    const row =
                        document.createElement("tr");


                    const firstInitial =
                        (
                            employee.first_name ||
                            ""
                        )
                        .charAt(0)
                        .toUpperCase();


                    const fullName =
                        (
                            employee.first_name ||
                            ""
                        ) +
                        " " +
                        (
                            employee.last_name ||
                            ""
                        );


                    const status =
                        (
                            employee.status ||
                            ""
                        )
                        .toLowerCase();


                    const statusHtml =
                        status === "active"

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
                                    ${firstInitial}
                                </div>

                                <div>

                                    <div class="employee-name">
                                        ${escapeHtml(fullName)}
                                    </div>

                                    <div class="employee-id">
                                        ${escapeHtml(employee.employee_id || "")}
                                    </div>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="department-name">
                                ${escapeHtml(employee.department_name || "")}
                            </span>

                        </td>


                        <td>

                            <span class="designation">
                                ${escapeHtml(employee.designation || "")}
                            </span>

                        </td>


                        <td>

                            <span class="email">
                                ${escapeHtml(employee.email || "")}
                            </span>

                        </td>


                        <td>

                            <span class="phone">
                                ${escapeHtml(employee.phone || "")}
                            </span>

                        </td>


                        <td>

                            <span class="salary">
                                ₹${escapeHtml(employee.salary || "")}
                            </span>

                        </td>


                        <td>
                            ${statusHtml}
                        </td>


                        <td class="text-end">

                            <a
                                href="view.php?employee_id=${encodeURIComponent(employee.employee_id)}"
                                class="action-btn me-1"
                                title="View Employee"
                            >
                                👁
                            </a>


                            <a
                                href="edit.php?employee_id=${encodeURIComponent(employee.employee_id)}"
                                class="action-btn"
                                title="Edit Employee"
                            >
                                ✎
                            </a>


                            <a
                                href="deactivate.php?employee_id=${encodeURIComponent(employee.employee_id)}"
                                class="action-btn"
                                title="Deactivate Employee"
                                onclick="return confirm('Are you sure you want to deactivate this employee?');"
                            >
                                ⏸
                            </a>

                        </td>
                        `;


                    employeeTableBody.appendChild(
                        row
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | EMPLOYEE COUNT
        |--------------------------------------------------------------------------
        */

        employeeCount.innerHTML =
            `
            Showing
            <strong>
                ${employees.length}
            </strong>
            employee(s)
            `;


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        createPagination(
            pageData.current_page || 1,
            pageData.total_pages || 0
        );


    } catch (error) {

        employeeTableBody.innerHTML =
            `
            <tr>
                <td
                    colspan="8"
                    class="empty-state"
                >
                    Unable to load employees.
                </td>
            </tr>
            `;


        showMessage(
            error.message ||
            "Unable to connect to Employee API.",
            false
        );
    }
}


/*
|--------------------------------------------------------------------------
| CREATE PAGINATION
|--------------------------------------------------------------------------
*/

function createPagination(
    page,
    totalPages
)
{
    pagination.innerHTML = "";


    if (totalPages <= 0) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | PREVIOUS
    |--------------------------------------------------------------------------
    */

    const previous =
        document.createElement("li");

    previous.className =
        "page-item " +
        (
            page <= 1
                ? "disabled"
                : ""
        );


    if (page > 1) {

        previous.innerHTML =
            `
            <a
                href="#"
                class="page-link"
            >
                Previous
            </a>
            `;


        previous.querySelector("a")
            .addEventListener(
                "click",
                function (event)
                {

                    event.preventDefault();

                    currentPage =
                        page - 1;

                    loadEmployees();
                }
            );

    } else {

        previous.innerHTML =
            `
            <span class="page-link">
                Previous
            </span>
            `;
    }


    pagination.appendChild(
        previous
    );


    /*
    |--------------------------------------------------------------------------
    | PAGE NUMBERS
    |--------------------------------------------------------------------------
    */

    for (
        let i = 1;
        i <= totalPages;
        i++
    ) {

        const pageItem =
            document.createElement("li");


        pageItem.className =
            "page-item " +
            (
                i === page
                    ? "active"
                    : ""
            );


        pageItem.innerHTML =
            `
            <a
                href="#"
                class="page-link"
            >
                ${i}
            </a>
            `;


        pageItem.querySelector("a")
            .addEventListener(
                "click",
                function (event)
                {

                    event.preventDefault();

                    currentPage = i;

                    loadEmployees();
                }
            );


        pagination.appendChild(
            pageItem
        );
    }


    /*
    |--------------------------------------------------------------------------
    | NEXT
    |--------------------------------------------------------------------------
    */

    const next =
        document.createElement("li");


    next.className =
        "page-item " +
        (
            page >= totalPages
                ? "disabled"
                : ""
        );


    if (page < totalPages) {

        next.innerHTML =
            `
            <a
                href="#"
                class="page-link"
            >
                Next
            </a>
            `;


        next.querySelector("a")
            .addEventListener(
                "click",
                function (event)
                {

                    event.preventDefault();

                    currentPage =
                        page + 1;

                    loadEmployees();
                }
            );

    } else {

        next.innerHTML =
            `
            <span class="page-link">
                Next
            </span>
            `;
    }


    pagination.appendChild(
        next
    );
}


/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

document.getElementById(
    "searchForm"
).addEventListener(
    "submit",
    function (event)
    {

        event.preventDefault();

        currentPage = 1;

        loadEmployees();
    }
);


/*
|--------------------------------------------------------------------------
| DEPARTMENT FILTER
|--------------------------------------------------------------------------
*/

departmentSelect.addEventListener(
    "change",
    function ()
    {

        currentPage = 1;

        loadEmployees();
    }
);


/*
|--------------------------------------------------------------------------
| STATUS FILTER
|--------------------------------------------------------------------------
*/

statusSelect.addEventListener(
    "change",
    function ()
    {

        currentPage = 1;

        loadEmployees();
    }
);


/*
|--------------------------------------------------------------------------
| SORT
|--------------------------------------------------------------------------
*/

sortSelect.addEventListener(
    "change",
    function ()
    {

        currentPage = 1;

        loadEmployees();
    }
);


/*
|--------------------------------------------------------------------------
| RESET
|--------------------------------------------------------------------------
*/

document.getElementById(
    "resetButton"
).addEventListener(
    "click",
    function ()
    {

        searchInput.value = "";

        departmentSelect.value = "";

        statusSelect.value = "";

        sortSelect.value = "";

        currentPage = 1;

        messageBox.innerHTML = "";

        loadEmployees();
    }
);


/*
|--------------------------------------------------------------------------
| HTML ESCAPE
|--------------------------------------------------------------------------
*/

function escapeHtml(value)
{
    return String(value)
        .replace(
            /&/g,
            "&amp;"
        )
        .replace(
            /</g,
            "&lt;"
        )
        .replace(
            />/g,
            "&gt;"
        )
        .replace(
            /"/g,
            "&quot;"
        )
        .replace(
            /'/g,
            "&#039;"
        );
}


/*
|--------------------------------------------------------------------------
| INITIAL LOAD
|--------------------------------------------------------------------------
*/

loadEmployees();
