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


function escapeHtml(value)
{
    return String(value ?? "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}


function showMessage(
    text,
    success
)
{
    message.innerHTML =
        `
        <div class="alert ${success ? "alert-success" : "alert-danger"}">
            ${escapeHtml(text)}
        </div>
        `;
}


deactivateButton.addEventListener(
    "click",
    async function ()
    {

        if (!departmentId) {

            showMessage(
                "Invalid department ID.",
                false
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
                true
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

            showMessage(
                error.message ||
                "Unable to deactivate department.",
                false
            );


            deactivateButton.disabled = false;

            deactivateButton.textContent =
                "Deactivate Department";
        }

    }
);