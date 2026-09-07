const API_URL =
    "/Employee_App/routes/api.php/departments/";


const urlParams =
    new URLSearchParams(window.location.search);


const departmentId =
    (urlParams.get("department_id") || "").trim();


const deactivateButton =
    document.getElementById("deactivateButton");


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
| SHOW MESSAGE
|--------------------------------------------------------------------------
*/

function showMessage(text, type)
{
    message.innerHTML = `
        <div class="alert alert-${type}">
            ${escapeHtml(text)}
        </div>
    `;
}


/*
|--------------------------------------------------------------------------
| DEACTIVATE DEPARTMENT
|--------------------------------------------------------------------------
*/

deactivateButton.addEventListener(
    "click",
    async function ()
    {
        if (departmentId === "") {

            showMessage(
                "Invalid department ID.",
                "danger"
            );

            return;
        }


        const confirmed =
            confirm(
                "Are you sure you want to deactivate this department?"
            );


        if (!confirmed) {
            return;
        }


        deactivateButton.disabled = true;

        deactivateButton.textContent =
            "Deactivating...";


        try {

            const response =
                await fetch(
                    API_URL +
                    encodeURIComponent(departmentId),
                    {
                        method: "DELETE",
                        credentials: "same-origin",
                        headers: {
                            "Accept": "application/json"
                        }
                    }
                );


            const text =
                await response.text();


            console.log(
                "Department deactivate response:",
                text
            );


            let result;

            try {

                result =
                    JSON.parse(text);

            } catch (error) {

                throw new Error(
                    "Department API did not return valid JSON."
                );
            }


            if (!response.ok || !result.success) {

                throw new Error(
                    result.message ||
                    "Unable to deactivate department."
                );
            }


            showMessage(
                result.message ||
                "Department deactivated successfully.",
                "success"
            );


            setTimeout(
                function ()
                {
                    window.location.href =
                        "index.php";
                },
                1200
            );


        } catch (error) {

            console.error(
                "Department Deactivate Error:",
                error
            );


            showMessage(
                error.message ||
                "Unable to deactivate department.",
                "danger"
            );


            deactivateButton.disabled = false;

            deactivateButton.textContent =
                "Deactivate Department";
        }
    }
);