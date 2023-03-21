var idNum;
var dataTable;

function displayData(dataFromTable)
{
        dataTable =  $('#dataTable').DataTable({
        columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
                 }],
        columns: [
                { 'data': 'firstName' },
                { 'data': 'lastName' },
                { 'data': 'phone' },
                { 'data': 'email' },
               ],
        data: dataFromTable, // Populates with data from table
        "bLengthChange": false, // Hides changing # of entries shown
        "sDom": 'lrtip', // Hides default search box
        "bInfo": false,  // Hides # of entries currently shown
        select: true }); // Allows selection of a single row to be highlighted
      
        // Allows for clicking on rows
        dataTable = $('#dataTable').DataTable();
        dataTable.on('click', 'tbody tr', function() {
        console.log('API row values : ', dataTable.row(this).data());
        idNum = dataTable.row(this).data().ID;
        
        // Allows selection of a single row to be highlighted
        if ($(this).hasClass('selected')) {
          $(this).removeClass('selected'); 
          $('button[type="button2"]').disable(true); // Disables buttons if selected already and then clicked on again
          $('button[type="button3"]').disable(true);
        }
        else {
          $('#dataTable tr.selected').removeClass('selected');
          $(this).addClass('selected');
          $('button[type="button2"]').disable(false); // Enables buttons if not selected and then clicked on
          $('button[type="button3"]').disable(false);
        }
      })
      // Allows for use of our own search input field
      $("#searchContact").keyup(function() {
        $('#dataTable').dataTable().fnFilter(this.value);
      });
}

// Disable function for buttons
jQuery.fn.extend({
  disable: function(state) {
    return this.each(function() {
      this.disabled = state;
    });
  }
});