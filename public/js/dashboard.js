const SUMMARY_API =
    "/Employee_App/routes/api.php/dashboard/summary";

const DEPARTMENT_API =
    "/Employee_App/routes/api.php/dashboard/employees-by-department";


document.addEventListener("DOMContentLoaded", function () {

    loadDashboardSummary();
    loadEmployeesByDepartment();

});


/* =========================================
   Dashboard Summary
   ========================================= */

async function loadDashboardSummary() {

    try {

        const response = await fetch(SUMMARY_API, {
            method: "GET",
            credentials: "same-origin"
        });

        const result = await response.json();


        if (!response.ok || !result.success) {

            throw new Error(
                result.message || "Failed to load dashboard summary."
            );

        }


        const data = result.data;


        const totalEmployees =
            document.getElementById("totalEmployees");

        const activeEmployees =
            document.getElementById("activeEmployees");

        const inactiveEmployees =
            document.getElementById("inactiveEmployees");

        const totalDepartments =
            document.getElementById("totalDepartments");


        if (totalEmployees) {
            totalEmployees.textContent =
                data.total_employees ?? 0;
        }


        if (activeEmployees) {
            activeEmployees.textContent =
                data.active_employees ?? 0;
        }


        if (inactiveEmployees) {
            inactiveEmployees.textContent =
                data.inactive_employees ?? 0;
        }


        if (totalDepartments) {
            totalDepartments.textContent =
                data.total_departments ?? 0;
        }


    } catch (error) {

        console.error(
            "Dashboard summary error:",
            error
        );

    }

}


/* =========================================
   Employees By Department
   ========================================= */

async function loadEmployeesByDepartment() {

    const container =
        document.getElementById("departmentSummaryBody");


    if (!container) {
        return;
    }


    try {

        const response = await fetch(DEPARTMENT_API, {
            method: "GET",
            credentials: "same-origin"
        });


        const result = await response.json();


        if (!response.ok || !result.success) {

            throw new Error(
                result.message ||
                "Failed to load department data."
            );

        }


        const data = result.data;


        container.innerHTML = "";


        if (!Array.isArray(data) || data.length === 0) {

            container.innerHTML = `
                <div class="empty-message">
                    No department data found.
                </div>
            `;

            return;
        }


        data.forEach(function (department) {

            const item =
                document.createElement("div");


            item.className =
                "department-summary-item";


            item.innerHTML = `
                <span class="department-name">
                    ${escapeHtml(department.department_name)}
                </span>

                <strong class="department-count">
                    ${escapeHtml(department.employee_count)}
                </strong>
            `;


            container.appendChild(item);

        });


    } catch (error) {

        console.error(
            "Department dashboard error:",
            error
        );


        container.innerHTML = `
            <div class="error-message">
                Unable to load department data.
            </div>
        `;

    }

}


/* =========================================
   HTML Escape
   ========================================= */

function escapeHtml(value) {

    return String(value ?? "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");

}