<script>
        function showNotificationIfNeeded(dateString, task) {
            Notification.requestPermission().then(function(permission) {
                if (permission === "granted") {
                    const now = new Date();
                    const reminderDate = new Date(dateString);

                    if (
                        reminderDate.getDate() === now.getDate() &&
                        reminderDate.getMonth() === now.getMonth() &&
                        reminderDate.getFullYear() === now.getFullYear()
                    ) {
                        const notification = new Notification("Reminder", {
                            body: "Hari ini adalah tanggal reminder!"
                        });

                        notification.onclick = function() {
                            console.log("Notifikasi diklik!");
                        };
                    }
                }
            });
        }
        
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "../mod/setting/getDateRemender.php", true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const reminderData = JSON.parse(xhr.responseText);
                const now = new Date();

                reminderData.forEach(function(item) {
                    const reminderDate = new Date(item.tanggal);

                    if (
                        reminderDate.getDate() === now.getDate() &&
                        reminderDate.getMonth() === now.getMonth() &&
                        reminderDate.getFullYear() === now.getFullYear()
                    ) {
                        showNotificationIfNeeded(reminderDate, item.taks);
                    }
                });
            }
        };

        xhr.send();
    </script>