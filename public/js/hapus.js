//hapus

function confirmDelete(id) {
    Swal.fire({
        title: "Anda yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6777ef",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus data!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("delete-form-" + id).submit();
        }
    });
}
