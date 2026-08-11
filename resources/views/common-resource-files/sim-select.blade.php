<link href="https://unpkg.com/slim-select@latest/dist/slimselect.css" rel="stylesheet"></link>
<script src="https://unpkg.com/slim-select@3.0.6/dist/slimselect.js"></script>
<script>
    // new SlimSelect({
    //     select: '.select2',
    //     events: {
    //         // Example: Exact case sensitive start of string match
    //         // searchFilter: (option, search) => {
    //         //     return option.text.substr(0, search.length) === search
    //         // }
    //
    //         // Default
    //         searchFilter: (option, search) => {
    //             return option.text.toLowerCase().indexOf(search.toLowerCase()) !== -1
    //         }
    //     }
    // })
    document.querySelectorAll('.select2').forEach(function (el) {
        new SlimSelect({
            select: el,
            events: {
                searchFilter: (option, search) => {
                    return option.text.toLowerCase().indexOf(search.toLowerCase()) !== -1;
                }
            }
        });
    });

</script>

<style>
    .ss-search {display: none!important;}
</style>
