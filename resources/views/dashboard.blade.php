@extends('elulacms::layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div style="text-align: center;">
        <h1>Welcome to the Elula CMS Dashboard</h1>
        <p>Create collections, page data and manage CMS users</p>
        {{-- form --}}
        <input type="text" id="collectionName" placeholder="Collection Name">
        <br><br>
        <div id="arrPrint"></div>
        <br><br>
        <button onclick="addField(event)">Add Field</button>
        <br><br>
        <button onclick="createCollection(event)">Create Collection</button>
        <p id="result"></p>
    </div>
    <script>
        //Variables
        const fieldTypes = [{
                id: 1,
                desc: "Text"
            },
            {
                id: 2,
                desc: "Rich Text"
            },
            {
                id: 3,
                desc: "Number"
            },
            {
                id: 4,
                desc: "Image"
            },
            {
                id: 5,
                desc: "Date"
            },
            {
                id: 6,
                desc: "Boolean"
            },
        ];
        let fieldsArray = [{
            title: '',
            id: null
        }, ];
        let jsToHTML = ``;

        //Functions
        document.onload = onLoad();

        function onLoad() {
            fieldsArray.forEach(function(el, index) {
                jsToHTML = jsToHTML + `<input type="text" placeholder="Field Name" onchange="updateArray(event, ${index})" id="field-${index}" value="${el.title}"><select onchange="updateArrayFromSelect(event, ${index})" name="" id="">
                <option default selected>Select Type</option>` + getFieldTypes() +
                    `</select><button onclick="removeField(${index})">remove</button> <br /><br />`
            });
            document.getElementById("arrPrint").innerHTML = jsToHTML;
        }

        function getFieldTypes() {
            let types = ``;
            fieldTypes.forEach(function(el) {
                types = types + `<option value="${el.id}">${el.desc}</option>`
            });
            return types;
        }

        //onchange inputs
        function updateArray(e, fieldIndex) {
            fieldsArray.forEach(function(el, index) {
                if (fieldIndex === index) {
                    fieldsArray[index].title = e.target.value;
                }
            });
        }

        //onchange selects
        function updateArrayFromSelect(e, selectIndex) {
            fieldsArray[selectIndex].id = parseInt(e.target.value);
        }

        function removeField(index) {
            fieldsArray.splice(index, 1)
            updateState();
        }

        //Add new field
        function addField(e) {
            e.preventDefault();
            fieldsArray.push({
                title: '',
                id: null
            })
            updateState();
        }

        function updateState() {
            //Update HTML
            jsToHTML = ``;
            fieldsArray.forEach(function(el, index) {
                jsToHTML = jsToHTML +
                    `<input type="text" placeholder="Field Name" value="${el.title}" onchange="updateArray(event, ${index})" id="field-${index}">`;
                if (el.id == null) {
                    jsToHTML = jsToHTML +
                        `<select onchange="updateArrayFromSelect(event, ${index})" name="" id=""><option selected>Select Type</option>` +
                        getFieldTypes() +
                        `</select><button onclick="removeField(${index})">remove</button> <br /><br />`;
                }

                if (el.id !== null) {
                    jsToHTML = jsToHTML +
                        `<select onchange="updateArrayFromSelect(event, ${index})" name="" id=""><option selected value="${el.id}">${getFieldDescById(el.id)}</option>` +
                        getFieldTypes() +
                        `</select><button onclick="removeField(${index})">remove</button><br /><br />`;
                }
            });

            document.getElementById("arrPrint").innerHTML = jsToHTML;
        }

        function getFieldDescById(id) {
            let desc = '';
            fieldTypes.forEach(function(el) {
                el.id == id ? desc = el.desc : '';
            });
            return desc;
        }

        function createCollection(e) {
            const collectionName = document.querySelector('#collectionName');
            const data = {
                collectionName: collectionName.value,
                fieldTypes: fieldsArray
            }
            document.getElementById("result").innerHTML = JSON.stringify(data);

            let url = "/cms/addCollection";

            let xhr = new XMLHttpRequest();
            xhr.open("POST", url);
            xhr.setRequestHeader("Accept", "application/json");
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    console.log(xhr.responseText);
                }
            };

            xhr.send(data);
        }
    </script>
@endsection
