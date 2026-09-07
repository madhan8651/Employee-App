const urlParams =
    new URLSearchParams(window.location.search);

const employeeId =
    (urlParams.get("employee_id") || "").trim();

const deactivateButton =
    document.getElementById("deactivateButton");

const messageBox =
    document.getElementById("message");


function escapeHtml(value)
{
    return String(value ?? "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}


deactivateButton.addEventListener(
    "click",
    async function ()
    {
        if (employeeId === "") {

            messageBox.innerHTML = `
                <div class="alert alert-danger">
                    Invalid employee ID.
                </div>
            `;

            return;
        }


        const confirmed = confirm(
            "Are you sure you want to deactivate this employee?"
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
                    "/Employee_App/routes/api.php/employees/" +
                    encodeURIComponent(employeeId),
                    {
                        method: "DELETE",
                        credentials: "same-origin"
                    }
                );


            const text =
                await response.text();


            let result;


            try {

                result =
                    JSON.parse(text);

            } catch (error) {

                throw new Error(
                    text ||
                    "Invalid response from Employee API."
                );
            }


            if (!response.ok || !result.success) {

                throw new Error(
                    result.message ||
                    "Employee could not be deactivated."
                );
            }


            messageBox.innerHTML = `
                <div class="alert alert-success">
                    ${escapeHtml(result.message)}
                </div>
            `;


            setTimeout(
                function ()
                {
                    window.location.href =
                        "index.php";
                },
                1200
            );


        } catch (error) {

            messageBox.innerHTML = `
                <div class="alert alert-danger">
                    ${escapeHtml(
                        error.message ||
                        "Unable to deactivate employee."
                    )}
                </div>
            `;


            deactivateButton.disabled = false;

            deactivateButton.textContent =
                "Deactivate Employee";
        }
    }
);