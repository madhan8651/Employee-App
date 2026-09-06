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

const deactivateButton =
    document.getElementById("deactivateButton");


/*
|--------------------------------------------------------------------------
| EMPLOYEE ID FROM URL
|--------------------------------------------------------------------------
*/

const urlParams =
    new URLSearchParams(window.location.search);

const employeeId =
    (urlParams.get("employee_id") || "").trim();


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

    setTimeout(function ()
    {
        messageBox.scrollIntoView({
            behavior: "smooth",
            block: "center"
        });
    }, 100);
}


/*
|--------------------------------------------------------------------------
| ESCAPE HTML
|--------------------------------------------------------------------------
*/

function escapeHtml(value)
{
    const div =
        document.createElement("div");

    div.textContent =
        value ?? "";

    return div.innerHTML;
}


/*
|--------------------------------------------------------------------------
| DEACTIVATE EMPLOYEE
|--------------------------------------------------------------------------
*/

if (deactivateButton) {

    deactivateButton.addEventListener(
        "click",
        async function ()
        {

            /*
            |----------------------------------------------------------------------
            | CHECK EMPLOYEE ID
            |----------------------------------------------------------------------
            */

            if (!employeeId) {

                showMessage(
                    "Employee ID is required.",
                    false
                );

                return;
            }


            /*
            |----------------------------------------------------------------------
            | BUTTON STATE
            |----------------------------------------------------------------------
            */

            deactivateButton.disabled = true;

            deactivateButton.textContent =
                "Deactivating...";


            try {

                /*
                |--------------------------------------------------------------------------
                | DELETE REQUEST
                |--------------------------------------------------------------------------
                */

                const response =
                    await fetch(
                        apiUrl +
                        encodeURIComponent(employeeId),
                        {
                            method: "DELETE",
                            credentials: "same-origin"
                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | RESPONSE
                |--------------------------------------------------------------------------
                */

                const responseText =
                    await response.text();


                let result;


                try {

                    result =
                        JSON.parse(responseText);

                } catch (error) {

                    showMessage(
                        "API Error: " +
                        responseText,
                        false
                    );

                    deactivateButton.disabled =
                        false;

                    deactivateButton.textContent =
                        "Deactivate Employee";

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | SUCCESS
                |--------------------------------------------------------------------------
                */

                if (result.success) {

                    showMessage(
                        result.message ||
                        "Employee deactivated successfully.",
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


                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | API FAILURE
                |--------------------------------------------------------------------------
                */

                showMessage(
                    result.message ||
                    "Unable to deactivate employee.",
                    false
                );


                deactivateButton.disabled =
                    false;

                deactivateButton.textContent =
                    "Deactivate Employee";

            } catch (error) {

                /*
                |--------------------------------------------------------------------------
                | REQUEST FAILURE
                |--------------------------------------------------------------------------
                */

                showMessage(
                    "Request failed: " +
                    error.message,
                    false
                );


                deactivateButton.disabled =
                    false;

                deactivateButton.textContent =
                    "Deactivate Employee";
            }

        }
    );

}