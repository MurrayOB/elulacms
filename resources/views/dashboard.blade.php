@extends('elulacms::layouts.master')
@section('title', 'Dashboard')
@section('content')
    <style>
        td {
            border: 1px solid rgb(87, 87, 87);
        }

        th,
        td {
            padding: 5px;
        }

        .publish-btn {
            text-align: center;
        }

        .greater-z {
            z-index: 10 !important;
        }

    </style>
    <div style="display: flex; flex-direction: row; justify-content: space-between;">
        <div style="display: flex; flex-direction: column">
            <h1 class="mytitle">Collections</h1>
            {{-- Display Collections --}}
            <p id="collections"></p>
            <br>
            <br>
            {{-- Popups --}}
            <h1>Popups</h1>
            <br>
            <br>
            <button>Edit Popups</button>
            {{-- Newsletter --}}
            <h1>Newsletter</h1>
            <br>
            <button>View Newsletters</button>
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
            {{-- Add Entry --}}
            <div id="addEntryModal" class="custom-modal">
                <div class="custom-modal-content">
                    <span onclick="closeModals()" class="custom-modal-close">&times;</span>
                    <button onclick="backBtn()">back</button>
                    <br>
                    <div id="addEntryModalData"></div>
                </div>
            </div>
            <!-- Collection Modal -->
            <div id="collectionModal" class="custom-modal">
                <div class="custom-modal-content">
                    <span onclick="closeModals()" class="custom-modal-close">&times;</span>
                    <div id="collectionData"></div>
                </div>
            </div>
            {{-- Edit Collection --}}
            <div id="editCollectionModal" class="custom-modal">
                <div class="custom-modal-content">
                    <span onclick="closeModals()" class="custom-modal-close">&times;</span>
                    <div id="editCollectionData"></div>
                </div>
            </div>
            {{-- Edit Entry --}}
            <div id="editEntryModal" class="custom-modal">
                <div class="custom-modal-content">
                    <span onclick="closeModals()" class="custom-modal-close">&times;</span>
                    <div id="editEntryData"></div>
                </div>
            </div>

        </div>
        <div style="display: flex; flex-direction: column">
            <img class="mt-1 mr-2 cursor-p" style="height: 30px"
                src="https://img.icons8.com/ios-filled/50/000000/settings.png" />
        </div>
    </div>
    <script>
        ////////////////////////////////////////////////////////////
        //Global Variables
        ////////////////////////////////////////////////////////////
        const collectionModal = document.getElementById("collectionModal");
        const addEntryModal = document.getElementById("addEntryModal");
        const editCollectionModal = document.getElementById("editCollectionModal");
        const editEntryModal = document.getElementById("editEntryModal");

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
        let globalCollections = [];
        let $globalSelectedCollection = null;
        let $globalAddEntryArray = [];

        ////////////////////////////////////////////////////////////
        //On Load
        ////////////////////////////////////////////////////////////

        window.addEventListener('load', function() {
            createEmptyField();
            loadCollections();
        });

        ////////////////////////////////////////////////////////////
        //Load Collections
        ////////////////////////////////////////////////////////////
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
            globalCollections = collections;
            console.log(globalCollections);
            collections.forEach(function(el) {
                collectionPrint +=
                    `<button onclick="openCollectionModal('${el.name}')">View ${el.name}</button><br/><br/>`;
            });
            document.getElementById("collections").innerHTML = collectionPrint;
        }

        ////////////////////////////////////////////////////////////
        //Create Collection Form
        ////////////////////////////////////////////////////////////
        function createEmptyField() {
            document.getElementById("arrPrint").innerHTML = `<input type="text" placeholder="Field Name" onchange="updateArray(event, 0)" id="field-0" value=""><select onchange="updateArrayFromSelect(event, 0)" name="" id="">
                <option default selected>Select Type</option>` + getFieldTypes() +
                `</select><button onclick="removeField(0)">remove</button> <br /><br />`;
        }

        function getFieldTypes() {
            let types = ``;
            fieldTypes.forEach(function(el) {
                types += `<option value="${el.id}">${el.desc}</option>`
            });
            return types;
        }

        function updateArray(e, fieldIndex) {
            //loadCollections();
            fieldsArray.forEach(function(el, index) {
                if (fieldIndex === index) {
                    fieldsArray[index].title = e.target.value;
                }
            });
        }

        function updateArrayFromSelect(e, selectIndex) {
            fieldsArray[selectIndex].id = parseInt(e.target.value);
        }

        function removeField(index) {
            fieldsArray.splice(index, 1)
            updateState();
        }

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

        ////////////////////////////////////////////////////////////
        //Collection Modal
        ////////////////////////////////////////////////////////////
        openCollectionModal = (collectionName) => {
            collectionModal.style.display = "block";
            let singleCollection = globalCollections.filter(function(el) {
                return el.name == collectionName;
            });
            singleCollection = singleCollection[0];
            $globalSelectedCollection = singleCollection;
            let actions =
                `<button onclick="editCollection()">Edit Collection</button> <button onclick="deleteCollection(${singleCollection.id})">Delete Collection</button>
            <button onclick="openAddEntryForm()" style="float: right">Add Entry +</button>`;
            let innerHTMLCollection =
                `<h2>${singleCollection.name}</h2>${actions}<br>`;
            let columns = '';
            let data = '';
            let keys = singleCollection.data[0];
            for (const key in keys) {
                columns += `<th>${key}</th>`;
            }
            columns += '<th>Status</th>';
            singleCollection.data.forEach(function(el, index) {
                let temp = '<tr>';
                for (const key in el) {
                    temp += `<td>${el[key]}</td>`;
                }
                temp +=
                    '<td class="publish-btn"><button>publish</button></td><td><button onclick="openEditEntryModal()">edit</button></td><td><button>delete</button></td></tr>';
                data += temp;
            });
            let table =
                `<table style="width:100%"><tr>${columns}</tr>${data}</table>`;
            innerHTMLCollection += `<br>${table}`;
            document.getElementById("collectionData").innerHTML = `<p>${innerHTMLCollection}</p>`;
        }

        function deleteCollection(collectionId) {
            axios.post('/cms/deleteCollection', {
                id: collectionId
            }).then(function(res) {
                if (res) {
                    loadCollections();
                    closeModals();
                }
            }).catch(function(error) {
                console.log(error);
            });
        }

        ////////////////////////////////////////////////////////////
        //Edit Collection Modal
        ////////////////////////////////////////////////////////////
        function editCollection() {
            collectionModal.style.display = "none";
            editCollectionModal.style.display = "block";
            editCollectionForm = `<button onclick="
            backBtn()
            ">Back</button><h1>Edit Collection</h1>`;
            document.getElementById("editCollectionData").innerHTML = editCollectionForm;
        }

        ////////////////////////////////////////////////////////////
        //Add Entry Modal
        ////////////////////////////////////////////////////////////
        function openAddEntryForm() {
            let entryForm = `<h2>${$globalSelectedCollection.name}</h2>`;
            addEntryModal.style.display = "block";
            collectionModal.style.display = "none";

            $globalSelectedCollection.fields.forEach(function(el, index) {
                entryForm += returnInputType(el.name, el.type, index);
            });

            entryForm += '<button onclick="addEntry()">Add Entry</button>'
            document.getElementById("addEntryModalData").innerHTML = entryForm;
        }

        function returnInputType(name, type, index) {
            $globalAddEntryArray.push({
                columnName: name,
                value: null
            });
            if (type == 1) {
                return `<input placeholder="${name}" type="text" onchange="updateEntryInput(event, ${index})"></input><br><br>`;
            }
        }

        function updateEntryInput(e, fieldIndex) {
            $globalAddEntryArray.forEach(function(el, index) {
                if (fieldIndex === index) {
                    $globalAddEntryArray[index].value = e.target.value;
                }
            });
        }

        function addEntry() {
            const data = {
                collectionName: $globalSelectedCollection.name,
                formData: $globalAddEntryArray
            }
            console.log(data);
            axios.post('/cms/addEntry', data)
                .then(function(response) {
                    console.log(response);
                }).catch(function(error) {
                    console.log(error);
                });

            $globalAddEntryArray = [];
            //if success
            addEntryModal.style.display = "none";
            openCollectionModal($globalSelectedCollection.name);
        }

        function backBtn() {
            addEntryModal.style.display = "none";
            editCollectionModal.style.display = "none";
            editEntryModal.style.display = "none";
            collectionModal.style.display = "block";
        }

        ////////////////////////////////////////////////////////////
        //Edit Modal
        ////////////////////////////////////////////////////////////
        function openEditEntryModal() {
            collectionModal.style.display = "none";
            editEntryModal.style.display = "block";
            editForm = `<button onclick="
            backBtn()
            ">Back</button>`;
            document.getElementById("editEntryData").innerHTML = editForm;
        }

        function updateEntry() {

        }

        ////////////////////////////////////////////////////////////
        //All Modals
        ////////////////////////////////////////////////////////////
        closeModals = () => {
            collectionModal.style.display = "none";
            addEntryModal.style.display = "none";
            editCollectionModal.style.display = "none";
            editEntryModal.style.display = "none";
        }
    </script>
@endsection
