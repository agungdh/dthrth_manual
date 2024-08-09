<script>
    function storeNotif(value) {
        localStorage.setItem('notif', JSON.stringify(value))
    }

    function pullNotif() {
        let data = JSON.parse(localStorage.getItem('notif'))

        localStorage.removeItem('notif')

        return data
    }
</script>
