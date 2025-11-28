// Generic List JavaScript - Applied to all list pages

document.addEventListener('DOMContentLoaded', function() {
    // Prevent text selection on table rows
    const tableRows = document.querySelectorAll('.modern-list-table tbody tr, table.dataTable tbody tr');
    tableRows.forEach(function(row) {
        // Prevent selection on click
        row.addEventListener('mousedown', function(e) {
            if (e.target.tagName !== 'A' && e.target.tagName !== 'BUTTON' && !e.target.closest('a') && !e.target.closest('button')) {
                e.preventDefault();
            }
        });
        
        // Prevent selection on touch
        row.addEventListener('touchstart', function(e) {
            if (e.target.tagName !== 'A' && e.target.tagName !== 'BUTTON' && !e.target.closest('a') && !e.target.closest('button')) {
                e.preventDefault();
            }
        });
        
        // Clear any existing selection
        row.addEventListener('click', function() {
            if (window.getSelection) {
                window.getSelection().removeAllRanges();
            }
            if (document.selection) {
                document.selection.empty();
            }
        });
    });
    
    // Prevent selection globally on the table
    const tables = document.querySelectorAll('.modern-list-table, table.dataTable');
    tables.forEach(function(table) {
        table.addEventListener('selectstart', function(e) {
            if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA' && !e.target.closest('a') && !e.target.closest('button')) {
                e.preventDefault();
            }
        });
    });
    
    // Remove DataTables selection classes if they exist
    if (typeof $.fn.dataTable !== 'undefined') {
        $(document).on('click', '.modern-list-table tbody tr, table.dataTable tbody tr', function() {
            $(this).siblings().removeClass('selected table-active');
            $(this).removeClass('selected table-active');
        });
    }
});

