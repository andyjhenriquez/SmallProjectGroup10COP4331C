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
          $('#button2').prop('disabled', true); // Disables buttons if selected already and then clicked on again
        }
        else {
          $('#dataTable tr.selected').removeClass('selected');
          $(this).addClass('selected');
          $('#button2').prop('disabled', false); // Enables buttons if not selected and then clicked on
        }
      })
      // Allows for use of our own search input field
      $("#searchContact").keyup(function() {
        $('#dataTable').dataTable().fnFilter(this.value);
      });
}