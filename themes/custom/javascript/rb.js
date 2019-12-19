$('.add-detail').on('click', function () {
    let parent = $(this).parent().parent()
    parent.find('tbody').append('<tr>' + parent.find('tr.table-row:last').html() + '</tr>')
    parent.find('tr.table-row:last td').each(function () {
        $(this).val("")
    })
    parent.find('.row-total').appendTo(parent.find('tbody'))
    parent.find('.typeahead:last').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    },
        {
            name: 'states',
            source: substringMatcher(states)
        }
    )
})

$(document).on('click', '.close-modal', function(){
    $('#' + $(this).attr('data-modal')).modal('hide');
})

$(".add-detail").click(function (e) {
    $(".select2-container").addClass("z-index-1");
    $(".select2-modal")
        .next()
        .removeClass("z-index-1");
    $(".select2-modal")
        .next()
        .css("width", "100%");
});

$(".close-modal").click(function (e) {
    setTimeout(() => {
        $(".select2-container").removeClass("z-index-1");
    }, 500);
});

$(document).on('click', '.delete-row', function () {
    // alert($('#table-body tr').length)
    let parent = $(this).parent().parent().parent().parent()
    console.log(parent.html())
    if (parent.find('tbody tr').length > 2) {
        // alert("Detailsss")
        let c = confirm("Apakah yakin akan menghapus data?")
        if (c)
            $(this).parent().parent().remove()
    }
    else {
        alert("Detail harus ada")
    }
})

var substringMatcher = function (strs) {
    return function findMatches(q, cb) {
        var matches, substringRegex;

        // an array that will be populated with substring matches
        matches = [];

        // regex used to determine if a string contains the substring `q`
        substrRegex = new RegExp(q, 'i');

        // iterate through the pool of strings and for any string that
        // contains the substring `q`, add it to the `matches` array
        $.each(strs, function (i, str) {
            if (substrRegex.test(str)) {
                matches.push(str);
            }
        });

        cb(matches);
    };
};

var states = $('#stored-val').data('val')

// console.log($('#stored-val').data('val'))

$('.typeahead').typeahead({
    hint: true,
    highlight: true,
    minLength: 1
},
    {
        name: 'states',
        source: substringMatcher(states)
    });
