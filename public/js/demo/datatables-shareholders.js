  $(document).ready(function() {
      //   var url = "{{route('datatableProcessing')}}";
      $('#shareholdersssDataTable').DataTable({
          "processing": true,
          "serverSide": true,
          "ajax": {
              "url": '../data/shareholders',
              "dataType": "json",
              "type": "POST",
              "data": { "_token": "<?php echo csrf_token() ?>" }
          },

          "columns": [
              { "data": "id" },
              { "data": "name" },
              { "data": "account_number" },
              { "data": "total_holdings" },
              { "data": "keypad" },
              { "data": "token" },
              { "data": "status" },
              { "data": "attendance" },
              { "data": "clicks" },
              { "data": "email" },
              { "data": "mobile" },
              { "data": "url" }
          ]
      });
  });