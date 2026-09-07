const API_URL =
    "/Employee_App/routes/api.php/departments";


/*
|--------------------------------------------------------------------------
| GET ELEMENTS
|--------------------------------------------------------------------------
*/

const form =
    document.getElementById("departmentForm");

const messageBox =
    document.getElementById("message");

const updateButton =
    document.getElementById("updateButton");

const departmentName =
    document.getElementById("department_name");

const description =
    document.getElementById("description");

const statusSelect =
    document.getElementById("status");


/*
|--------------------------------------------------------------------------
| CHECK ELEMENTS
|--------------------------------------------------------------------------
*/

if (!form) {
    console.error("departmentForm not found.");
}

if (!messageBox) {
    console.error("message element not found.");
}

if (!updateButton) {
    console.error("updateButton not found.");
}

if (!departmentName) {
    console.error("department_name element not found.");
}

if (!description) {
    console.error("description element not found.");
}

if (!statusSelect) {
    console.error("status element not found.");
}


/*
|--------------------------------------------------------------------------
| ESCAPE HTML
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

function showMessage(text, type = "danger")
{
    if (!messageBox) {
        console.error(text);
        return;
    }

    messageBox.innerHTML = `
        <div class="alert alert-${type}">
            ${escapeHtml(text)}
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

        console.log(
            "Loading department:",
            departmentId
        );


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


        const text =
            await response.text();


        console.log(
            "Department API response:",
            text
        );


        let result;


        try {

            result =
                JSON.parse(text);

        } catch (error) {

            throw new Error(
                "Department API returned invalid JSON."
            );
        }


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


        const department =
            result.data;


        if (!department) {

            throw new Error(
                "Department details not found."
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILL FORM
        |--------------------------------------------------------------------------
        */

        if (departmentName) {

            departmentName.value =
                department.department_name || "";

        }


        if (description) {

            description.value =
                department.description || "";

        }


        if (statusSelect) {

            statusSelect.value =
                department.status || "Active";

        }


        console.log(
            "Department details loaded successfully."
        );

    } catch (error) {

        console.error(
            "Load department error:",
            error
        );


        showMessage(
            error.message ||
            "Unable to load department."
        );


        if (updateButton) {
            updateButton.disabled = true;
        }
    }
}


/*
|--------------------------------------------------------------------------
| UPDATE DEPARTMENT
|--------------------------------------------------------------------------
*/

if (form) {

    form.addEventListener(
        "submit",
        async function (event)
        {
            event.preventDefault();


            if (updateButton) {

                updateButton.disabled = true;

                updateButton.textContent =
                    "Updating...";

            }


            const formData =
                new FormData(form);


            try {

                const response =
                    await fetch(
                        API_URL +
                        "/" +
                        encodeURIComponent(departmentId),
                        {
                            method: "POST",

                            headers: {
                                "X-HTTP-Method-Override": "PUT"
                            },

                            body: formData,

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
                        "Department API returned invalid JSON."
                    );
                }


                if (!response.ok || !result.success) {

                    throw new Error(
                        result.message ||
                        "Unable to update department."
                    );
                }


                showMessage(
                    result.message ||
                    "Department updated successfully.",
                    "success"
                );


                setTimeout(
                    function ()
                    {
                        window.location.href =
                            "index.php";
                    },
                    1000
                );


            } catch (error) {

                console.error(
                    "Update department error:",
                    error
                );


                showMessage(
                    error.message ||
                    "Unable to update department."
                );


                if (updateButton) {

                    updateButton.disabled = false;

                    updateButton.textContent =
                        "Update Department";
                }
            }
        }
    );

}


/*
|--------------------------------------------------------------------------
| INITIAL LOAD
|--------------------------------------------------------------------------
*/

loadDepartment();