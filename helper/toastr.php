<style>
.arapaah {
      margin-top: 30px;
    }
.arapaah-blue {
    background-color: #3498db;
    color: white;
  }

.arapaah-green {
    background-color: #27ae60;
    color: white;
  }

.arapaah-orange {
    background-color: #e67e22;
    color: white;
  }
</style>

<script>
  <?php
    $messages = [
      'delete' => ['color' => 'blue', 'text' => $item . ' Data telah dihapus'],
      'nodelete' => ['color' => 'orange', 'text' => 'Error! Tidak dapat melakukan operasi delete'],
      'update' => ['color' => 'blue', 'text' => $item . ' Data telah diupdate'],
      'noupdate' => ['color' => 'orange', 'text' => 'Error! Tidak dapat melakukan operasi update'],
      'reset' => ['color' => 'blue', 'text' => 'Data Telah direset'],
      'noreset' => ['color' => 'orange', 'text' => 'Error! Tidak dapat melakukan operasi reset data'],
      'import' => ['color' => 'blue', 'text' => 'Data berhasil diimport'],
      'noimport' => ['color' => 'orange', 'text' => 'Error! Tidak dapat melakukan operasi import data'],
      'nodata' => ['color' => 'orange', 'text' => 'Error! Database masih kosong!'],
      'noimport1' => ['color' => 'orange', 'text' => 'Error! Database error'],
      'cekok' => ['color' => 'blue', 'text' => 'Alhamdulillah, masuk kappi'],
      'noimport' => ['color' => 'orange', 'text' => 'Error! Tidak bisa melakukan operasi import'],
      'taks' => ['color' => 'blue', 'text' => 'Reminder baru telah masuk'],
      'notaks' => ['color' => 'orange', 'text' => 'Reminder tidak masuk'],
      'taks2' => ['color' => 'blue', 'text' => 'Reminder telah dihapus'],
      'notaks2' => ['color' => 'orange', 'text' => 'Reminder tidak bisa dihapus'],
      'insert' => ['color' => 'blue', 'text' => 'Siap! Tags sudah masok'],
      'noinsert' => ['color' => 'orange', 'text' => 'Tak masok'],
    ];
    
    if (isset($pesan) && array_key_exists($pesan, $messages)) {
      $message = $messages[$pesan];
      echo 'showCustomToastrNotification("arapaah-' . $message['color'] . '", "' . $message['text'] . '");';
    } else {
      // echo 'showCustomToastrNotification("arapaah-orange", "Pesan tidak dikenali");';
    }
  ?>

  function showCustomToastrNotification(customClass, message) {
    toastr.options = {
      closeButton: true,
      duration: 3000,
      positionClass: 'toast-top-right arapaah',
      progressBar: true,
      toastClass: customClass
    };
    toastr.success(message);
  }
</script>