// File: public/js/form-validation.js

function formatRupiah(input) {
    let displayValue = input.value.replace(/\D/g, ""); // Hapus semua karakter non-digit
    let formattedValue = displayValue.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Tambahkan titik setiap 3 angka
    input.value = formattedValue;

    // Set nilai asli tanpa format ke hidden input yang sesuai
    let hiddenInputId = input.id.replace("_display", "");
    document.getElementById(hiddenInputId).value = displayValue;
}

document
    .getElementById("anggaran_display")
    .addEventListener("input", function (e) {
        formatRupiah(e.target);
    });

document
    .getElementById("pengeluaran_display")
    .addEventListener("input", function (e) {
        formatRupiah(e.target);
    });

document.querySelector("form").addEventListener("submit", function (e) {
    let anggaranDisplayValue =
        document.getElementById("anggaran_display").value;
    let pengeluaranDisplayValue = document.getElementById(
        "pengeluaran_display"
    ).value;

    // Hapus titik sebelum submit
    document.getElementById("anggaran").value = anggaranDisplayValue.replace(
        /\./g,
        ""
    );
    document.getElementById("pengeluaran").value =
        pengeluaranDisplayValue.replace(/\./g, "");
});

// Form validation event listener
document
    .getElementById("DistribusiForm")
    .addEventListener("submit", function (e) {
        let isValid = true;
        let fields = [
            { id: "programs_id", message: "Program harus diisi" },
            { id: "tanggal", message: "Tanggal harus diisi" },
            { id: "tempat", message: "Tempat harus diisi" },
            { id: "penerima_manfaat", message: "Penerima Manfaat harus diisi" },
            { id: "anggaran_display", message: "Anggaran harus diisi" },
            { id: "file", message: "File harus diisi" },
        ];

        for (let field of fields) {
            let element = document.getElementById(field.id);
            if (!element.value) {
                isValid = false;
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: field.message,
                    confirmButtonColor: "#6777ef",
                });
                element.focus();
                e.preventDefault();
                break; // Stop checking further fields after the first empty field is found
            }
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
