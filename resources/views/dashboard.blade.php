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
        //Empty
        // let fieldsArray = [{
        //     title: '',
        //     id: null
        // }, ];
        let fieldsArray = [{
            title: 'Name',
            id: 1
        }, {
            title: 'Description',
            id: 2
        }, {
            title: 'ProfilePicture',
            id: 4
        }, {
            title: 'Active',
            id: 6
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

            const url = "/cms/addCollection";
            axios.post(url, data).then(function(response) {
                document.getElementById("result").innerHTML = JSON.stringify(response.message);
            }).catch(function(error) {
                document.getElementById("result").innerHTML = JSON.stringify(error.message);
            });

        }
    </script>
@endsection
