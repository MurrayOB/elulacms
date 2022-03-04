@extends('elulacms::layouts.master')
@section('title', 'Dashboard')
@section('content')
    <style>
    </style>
    <div style="display: flex; flex-direction: row; justify-content: space-between;">
        <div style="display: flex; flex-direction: column">
            <h1 class="mytitle">Collections</h1>
            <p id="collections"></p>
        </div>
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center">
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
            <!-- Collection Modal -->
            <button onclick="openCollectionModal()">Click</button>
            <div id="collectionModal" class="custom-modal">
                <div class="custom-modal-content">
                    <span onclick="closeCollectionModal()" class="custom-modal-close">&times;</span>
                    <p>Some text in the Modal..</p>
                </div>
            </div>
        </div>
        <div style="display: flex; flex-direction: column">
            <img class="mt-1 mr-2 cursor-p" style="height: 30px"
                src="https://img.icons8.com/ios-filled/50/000000/settings.png" />
        </div>
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
        const collectionModal = document.getElementById("collectionModal");

        window.addEventListener('load', function() {
            createEmptyField();
            loadCollections();
        });

        function createEmptyField() {
            // fieldsArray.forEach(function(el, index) {
            //     jsToHTML = jsToHTML + `<input type="text" placeholder="Field Name" onchange="updateArray(event, ${index})" id="field-${index}" value="${el.title}"><select onchange="updateArrayFromSelect(event, ${index})" name="" id="">
        //     <option default selected>Select Type</option>` + getFieldTypes() +
            //         `</select><button onclick="removeField(${index})">remove</button> <br /><br />`
            // });
            document.getElementById("arrPrint").innerHTML = `<input type="text" placeholder="Field Name" onchange="updateArray(event, 0)" id="field-0" value=""><select onchange="updateArrayFromSelect(event, 0)" name="" id="">
                <option default selected>Select Type</option>` + getFieldTypes() +
                `</select><button onclick="removeField(0)">remove</button> <br /><br />`;
        }

        function loadCollections() {
            const url = '/cms/getCollections';
            axios.get(url).then(function(response) {
                handleCollections(response.data.collections);
            }).catch(function(error) {
                document.getElementById("collections").innerHTML = error;
            });
        }

        function handleCollections(collections) {
            if (collections.length == 0) {
                document.getElementById("collections").innerHTML = 'You dont have any collections';
                return;
            }

            let collectionPrint = '';
            collections.forEach(function(el) {
                collectionPrint += `<button>View ${el.name}</button><br/><br/>`;
            });
            document.getElementById("collections").innerHTML = collectionPrint;
        }

        function getFieldTypes() {
            let types = ``;
            fieldTypes.forEach(function(el) {
                types += `<option value="${el.id}">${el.desc}</option>`
            });
            return types;
        }

        //onchange inputs
        function updateArray(e, fieldIndex) {
            loadCollections();
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
                jsToHTML +=
                    `<input type="text" placeholder="Field Name" value="${el.title}" onchange="updateArray(event, ${index})" id="field-${index}">`;
                if (el.id == null) {
                    jsToHTML +=
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
                document.getElementById("result").innerHTML = JSON.stringify(response.data.message);
                createEmptyField();
                loadCollections();
                document.getElementById("collectionName").value = '';
            }).catch(function(error) {
                document.getElementById("result").innerHTML = JSON.stringify(error.data.message);
            });
        }

        openCollectionModal = () => {
            collectionModal.style.display = "block";
        }

        closeCollectionModal = () => {
            collectionModal.style.display = "none";
        }
    </script>
@endsection
