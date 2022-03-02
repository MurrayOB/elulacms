@extends('elulacms::layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div style="text-align: center;">
        <h1>Welcome to the Elula CMS Dashboard</h1>
        <p>Create collections, page data and manage CMS users</p>
        <div style="">
            <input type="text" placeholder="Collection Name">
            <br><br>
            <pre id="arrPrint"></pre>
            <br><br>
            <button onclick="addField(event)">Add Field</button>
            <br><br>
            <button onclick="createCollection(event)">Create Collection</button>
            <p id="result"></p>
        </div>
    </div>
    <script>
        let arr = [{
            title: '',
            id: 0
        }, ];
        let jsToHTML = ``;

        document.onload = onLoad();

        function onLoad() {
            arr.forEach(function(el, index) {
                jsToHTML = jsToHTML + `<input type="text" placeholder="Field Name" onchange="updateArray(event, ${index})" id="field-${index}" value="${el.title}"> <select onchange="updateArrayFromSelect(event, ${index})" name="" id="">
                <option default selected>Select Type</option>
                <option value="0">Text</option>
                <option value="1">Rich Text</option>
                <option value="2">Number</option>
                <option value="3">Image</option>
                <option value="4">Date</option>
                <option value="5">Boolean</option>
            </select> <br /><br />`
            });
            document.getElementById("arrPrint").innerHTML = jsToHTML;
        }

        function updateArray(e, fieldIndex) {
            arr.forEach(function(el, index) {
                if (fieldIndex === index) {
                    arr[index].title = e.target.value;
                }
            });
            console.log(JSON.stringify(arr))
        }

        function updateArrayFromSelect(e, selectIndex) {
            console.log(selectIndex + e.target.value);
            arr[selectIndex].id = parseInt(e.target.value);
        }

        function addField(e) {
            e.preventDefault();

            arr.push({
                title: 'test3',
                id: -1
            })

            jsToHTML = ``;
            arr.forEach(function(el, index) {
                jsToHTML = jsToHTML +
                    `<input type="text" placeholder="Field Name" value="${el.title}" onchange="updateArray(event, ${index})" id="field-${index}">`;
                if (el.id < 0) {
                    jsToHTML = jsToHTML + `<select name="" id="">
                <option default selected>Select Type</option>
                <option value="0">Text</option>
                <option value="1">Rich Text</option>
                <option value="2">Number</option>
                <option value="3">Image</option>
                <option value="4">Date</option>
                <option value="5">Boolean</option>
            </select> <br /><br />`;
                } else {
                    jsToHTML = jsToHTML + `<select name="" id="">
                <option selected value="${el.id}">Text</option>
                <option value="0">Text</option>
                <option value="1">Rich Text</option>
                <option value="2">Number</option>
                <option value="3">Image</option>
                <option value="4">Date</option>
                <option value="5">Boolean</option>
            </select> <br /><br />`
                }

            });
            document.getElementById("arrPrint").innerHTML = jsToHTML;

        }

        function createCollection(e) {
            e.preventDefault();
            document.getElementById("result").innerHTML = JSON.stringify(arr)
        }
    </script>
@endsection
