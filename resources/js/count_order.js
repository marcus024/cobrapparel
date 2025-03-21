 let count = 1;

    function increaseCount() {
        count++;
        document.getElementById('orderCount').innerText = count;
    }

    function decreaseCount() {
        if (count > 1) {
            count--;
            document.getElementById('orderCount').innerText = count;
        }
    }