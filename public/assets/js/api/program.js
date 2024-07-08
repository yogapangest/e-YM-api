document.addEventListener("DOMContentLoaded", function () {
    fetchPrograms();
});

async function fetchPrograms() {
    try {
        const response = await fetch("/api/manajemen/program");
        const data = await response.json();

        if (data.status === "success") {
            populateTable(data.program);
        } else {
            alert("Failed to fetch programs.");
        }
    } catch (error) {
        console.error("Error fetching programs:", error);
    }
}

function populateTable(programs) {
    const tableBody = document.getElementById("program-table-body");
    tableBody.innerHTML = "";

    programs.forEach((program, index) => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${index + 1}</td>
            <td>${program.nama_program}</td>
            <td>${program.deskripsi}</td>
            <td>${
                program.file
                    ? `<a href="/file/program/${program.file}"><i class="fas fa-file-alt" style="font-size: 20px;"></i></a>`
                    : "<i>No file uploaded.</i>"
            }</td>
            <td class="text-center">
                <button class="btn btn-primary ml-2" onclick="editProgram(${
                    program.id
                })"><i class="fas fa-edit"></i></button>
                <button class="btn btn-danger ml-2" onclick="deleteProgram(${
                    program.id
                })"><i class="fas fa-trash-alt"></i></button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

async function addProgram() {
    const nama_program = prompt("Masukkan nama program:");
    const deskripsi = prompt("Masukkan deskripsi program:");
    const fileInput = document.createElement("input");
    fileInput.type = "file";
    fileInput.accept = "image/*,.pdf,.doc,.docx";

    fileInput.onchange = async () => {
        const file = fileInput.files[0];
        const formData = new FormData();
        formData.append("nama_program", nama_program);
        formData.append("deskripsi", deskripsi);
        if (file) {
            formData.append("file", file);
        }

        try {
            const response = await fetch("/api/manajemen/program", {
                method: "POST",
                body: formData,
            });
            const data = await response.json();

            if (data.status === "success") {
                fetchPrograms();
                alert("Program berhasil ditambahkan.");
            } else {
                alert("Gagal menambahkan program: " + data.message);
            }
        } catch (error) {
            console.error("Error adding program:", error);
        }
    };

    fileInput.click();
}

async function editProgram(id) {
    try {
        const response = await fetch(`/api/manajemen/program/${id}`);
        const data = await response.json();

        if (data.status === "success") {
            const program = data.program;
            const nama_program = prompt(
                "Edit nama program:",
                program.nama_program
            );
            const deskripsi = prompt(
                "Edit deskripsi program:",
                program.deskripsi
            );
            const fileInput = document.createElement("input");
            fileInput.type = "file";
            fileInput.accept = "image/*,.pdf,.doc,.docx";

            fileInput.onchange = async () => {
                const file = fileInput.files[0];
                const formData = new FormData();
                formData.append("_method", "PUT"); // Metode HTTP untuk update
                formData.append("nama_program", nama_program);
                formData.append("deskripsi", deskripsi);
                if (file) {
                    formData.append("file", file);
                }

                try {
                    const response = await fetch(
                        `/api/manajemen/program/${id}`,
                        {
                            method: "POST",
                            body: formData,
                        }
                    );
                    const data = await response.json();

                    if (data.status === "success") {
                        fetchPrograms();
                        alert("Program berhasil diupdate.");
                    } else {
                        alert("Gagal mengupdate program: " + data.message);
                    }
                } catch (error) {
                    console.error("Error updating program:", error);
                }
            };

            fileInput.click();
        } else {
            alert("Gagal mendapatkan data program: " + data.message);
        }
    } catch (error) {
        console.error("Error fetching program data:", error);
    }
}

async function deleteProgram(id) {
    try {
        const response = await fetch(`/api/manajemen/program/${id}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
            },
        });
        const data = await response.json();

        if (data.status === "success") {
            fetchPrograms();
            alert("Program berhasil dihapus.");
        } else {
            alert("Gagal menghapus program: " + data.message);
        }
    } catch (error) {
        console.error("Error deleting program:", error);
    }
}
