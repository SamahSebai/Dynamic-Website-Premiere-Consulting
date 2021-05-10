$('#treeview-checkbox-demo').treeview({
  debug: true,
  data: ['links', 'Do WHile loop']
});
$('#show-values').on('click', function() {
  $('#values').text(
    $('#treeview-checkbox-demo').treeview('selectedValues')
  );
});