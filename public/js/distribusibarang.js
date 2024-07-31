document
    .getElementById("DistribusiBarangForm")
    .addEventListener("submit", function (e) {
        let isValid = true;
        let fields = [
            {
                id: "nama_barang",
                message: "Nama harus diisi",
            },
            {
                id: "volume",
                message: "volume harus diisi",
            },
            {
                id: "satuan",
                message: "satuan harus diisi",
            },
            {
                id: "harga_satuan",
                message: "harga_satuan harus diisi",
            },
        ];

        for (let field of fields) {
            let element = document.getElementById(field.id);
            if (!element.value) {
                isValid = false;
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: field.message,
                    confirmButtonText: "Oke",
                    confirmButtonColor: "#6777ef", // Warna primary Laravel/Bootstrap
                });
                element.focus();
                e.preventDefault();
                break; // Break the loop after the first invalid field is found
            }
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
