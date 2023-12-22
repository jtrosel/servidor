
export const $ = (selector) => {
    return document.querySelector(selector);
};

/**
* Funcion para hacer una solicitud HTTP a la API y obtener usuarios
* @returns Promise<void>
*/
export async function obtenerUsuarios() {

    /**
     * Desactivar el boton
     */
    $('#get_users').setAttribute('disabled', true);

    /**
     * Se limpia el div de resultados
     */
    $("#result").innerHTML = `
        <p class="placeholder-glow">
            <span class="placeholder col-12"></span>
        </p>
            <p class="placeholder-glow">
            <span class="placeholder col-12"></span>
        </p>
            <p class="placeholder-glow">
            <span class="placeholder col-12"></span>
        </p>
            <p class="placeholder-glow">
            <span class="placeholder col-12"></span>
        </p>
   `;

    /**
     * URL de la API
     */
    const url = "http://localhost/clases/servidor/api/v1/users/index.php";

    /**
     * Options de la solicitud HTTP
     */
    const options = {
        method: "GET",
        headers: {
            Accept: "application/json",
        },
    };

    try {
        const response = await fetch(url, options);

        switch (response.status) {
            case 200:
                const data = await response.json();
                setTimeout(() => {
                    $("#result").innerHTML = `
                        <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Primer Nombre</th>
                                <th scope="col">Segundo Nombre</th>
                                <th scope="col">Primer Apellido</th>
                                <th scope="col">Segundo Apellido</th>
                                <th scope="col">Cedula</th>
                                <th scope="col">Creado el</th>
                            </tr>
                        </thead>
                        <tbody id='table-body'>
                        </tbody>
                    </table>`;
                    data.data.forEach(user => {
                        $("#table-body").innerHTML += `
                        <tr>
                        <td>${user.id}</td>
                        <td>${user.first_name}</td>
                        <td>${user.middle_name}</td>
                        <td>${user.lastname}</td>
                        <td>${user.second_lastname}</td>
                        <td>${user.document}</td>
                        <td>${user.created_at}</td>
                        </tr>
                        `;
                    });
                }, 2000)
                break;
            case 204:
                console.log("No se encontraron users");
                break;
            case 400:
                console.log("Error de validacion");
                break;
            case 500:
                console.log("Error del servidor");
                break;
            default:
                console.log("Error desconocido ", response.status);
                break;
        }
    } catch (error) {
        console.log(error);
        alert('Ocurrio un error ' + error)
    } finally {
        setTimeout(() => {
            $('#get_users').removeAttribute('disabled')
        }, 3000);
    }
    return;
};

export const createUser = async () => {
    const url = 'http://localhost/clases/servidor/api/v1/users/index.php';

    const datos = new URLSearchParams();

    const first_name = $('#first_name').value;

    datos.append('first_name', first_name);

    const options = {

    }

    try {
        const response = '';
    } catch (error) {

    }
}