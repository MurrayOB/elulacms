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
            <h1 class="mytitle">Elulacms</h1>
            <button onclick="openCreateCollectionModal()">Create Collection</button>
            <h2 class="mytitle">Collections</h2>
            {{-- Display Collections --}}
            <p id="collections"></p>
            <br>
            <br>
            {{-- Popups --}}
            {{-- <h2>Popups</h2>
            <br>
            <br>
            <button>Edit Popups</button> --}}
            {{-- Newsletter --}}
            {{-- <h2>Newsletter</h2>
            <br>
            <button>View Newsletters</button> --}}
        </div>
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center">
            <h1>Welcome to the Elula CMS Dashboard</h1>
            <p>Create collections, page data and manage CMS users</p>
            {{-- Create Collection Modal Form --}}
            <div id="createCollectionModal" class="custom-modal">
                <div class="custom-modal-content">
                    <span onclick="closeModals()" class="custom-modal-close">&times;</span>
                    <br>
                    <h2>Create Collection</h2>
                    <input type="text" id="collectionName" placeholder="Collection Name">
                    <br><br>
                    <div id="arrPrint"></div>
                    <button onclick="addField(event)">Add Field</button>
                    <br><br>
                    <button onclick="createCollection(event)">Create Collection</button>
                    <p id="result"></p>
                </div>
            </div>
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
        const createCollectionModal = document.getElementById("createCollectionModal");
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
        let $globalCollections = [];
        let $globalSelectedCollection = null;
        let $globalAddEntryArray = [];
        let $globalUpdateEntry = null;

        let $globalEditCollectionArray = [];
        let $globalRemoveField = [];

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
            $globalCollections = collections;
            collections.forEach(function(el) {
                collectionPrint +=
                    `<button onclick="openCollectionModal('${el.name}')">View ${el.name}</button><br/><br/>`;
            });
            document.getElementById("collections").innerHTML = collectionPrint;
        }

        ////////////////////////////////////////////////////////////
        //Create Collection Form
        ////////////////////////////////////////////////////////////
        function openCreateCollectionModal() {
            createCollectionModal.style.display = "block";
        }

        function createEmptyField() {
            document.getElementById("arrPrint").innerHTML = `<input type="text" placeholder="Field Name" onchange="updateArray(event, 0)" id="field-0" value=""><select onchange="updateArrayFromSelect(event, 0)" name="" id="">
                <option default selected>Select Type</option>` + getFieldTypes() +
                `</select><button onclick="removeField(0)">remove</button> <br /><br />`;
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
            fieldsArray.splice(index, 1);
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
            let singleCollection = $globalCollections.filter(function(el) {
                return el.name == collectionName;
            });
            singleCollection = singleCollection[0];
            $globalSelectedCollection = singleCollection;
            let actions =
                `<p>api: ${singleCollection.name}</p><br><button onclick="editCollection()">Edit Collection</button> <button onclick="deleteCollection(${singleCollection.id})">Delete Collection</button>
            <button onclick="openAddEntryForm()" style="float: right">Add Entry +</button>`;
            let innerHTMLCollection =
                `<h2>${singleCollection.name}</h2>${actions}<br>`;
            let columns = '';
            let data = '';
            let keys = singleCollection.data[0];
            let i = 0;
            let publishKeyIndex = 0;
            for (const key in keys) {
                if (key == 'published') {
                    publishKeyIndex = i;
                } else {
                    columns += `<th>${key}</th>`;
                }
                i += 1;
            }
            columns += '<th>Status</th>';
            singleCollection.data.forEach(function(el, index) {
                let temp = '<tr>';
                let x = 0;
                for (const key in el) {
                    if (x == publishKeyIndex) {

                    } else {
                        temp += `<td>${el[key]}</td>`;
                    }
                    x += 1;
                }
                temp +=
                    `<td class="publish-btn"><button onclick="publishEntry(${el.id}, '${singleCollection.name}')">${el.published == 0 ? 'publish': 'unpublish'}</button></td><td><button onclick="openEditEntryModal(${el.id}, '${singleCollection.name}')">edit</button></td><td><button onclick="deleteEntry(${el.id}, '${singleCollection.name}')">delete</button></td></tr>`;
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

        function deleteEntry(id, collectionName) {
            const data = {
                id: id,
                collectionName: collectionName
            }
            axios.post('/cms/deleteEntry', data).then(function(res) {
                location.reload();
            }).catch(function(err) {
                console.log(err);
            });
        }

        function publishEntry(id, collectionName) {
            const data = {
                id: id,
                collectionName: collectionName
            }
            axios.post('/cms/publishEntry', data).then(function(res) {
                location.reload();
            }).catch(function(err) {
                console.log(err);
            });
        }

        ////////////////////////////////////////////////////////////
        //Edit Collection Modal
        ////////////////////////////////////////////////////////////
        function editCollection() {
            collectionModal.style.display = "none";
            editCollectionModal.style.display = "block";

            $globalEditCollectionArray = [];
            $globalEditCollectionArray = JSON.parse(JSON.stringify($globalSelectedCollection.fields));
            $globalEditCollectionArray.updatedCollectionName = JSON.parse(JSON.stringify($globalSelectedCollection.name));
            updateEditCollectionState();
        }

        function updateEditCollectionState() {
            let editCollectionForm =
                `<button onclick="
            backBtn()
            ">Back</button><h1>Edit Collection</h1><button style="float: right" onclick="saveCollectionEdit()">SAVE CHANGES</button><br>`;
            editCollectionForm +=
                `<label>Collection Name: </label><input onchange="updateCollectionName(event)" value="${$globalEditCollectionArray.updatedCollectionName}" placeholder="Collection Name" /><br><br>`;
            $globalEditCollectionArray.forEach(function(el, index) {
                if (el.id == null) {
                    editCollectionForm +=
                        `<input onchange="renameField(event, ${index})" value="${el.name}" name="${el.name}" /><select onchange="updateFieldFromSelect(event, ${index})"><option default selected>Select Type</option>` +
                        getFieldTypes() +
                        `</select><button onclick="removeCollectionField(${index})">remove</button><br><br>`;
                } else {
                    editCollectionForm +=
                        `<input onchange="renameField(event, ${index})" value="${el.name}" name="${el.name}" /><button onclick="removeCollectionField(${index}, ${el.id})">remove</button><br><br>`;
                }
            });
            editCollectionForm += `<br><button onclick="addNewField()">Add Field</button>`;
            document.getElementById("editCollectionData").innerHTML = editCollectionForm;
        }

        function updateCollectionName(e) {
            $globalEditCollectionArray.updatedCollectionName = e.target.value;
        }

        function updateFieldFromSelect(e, index) {
            $globalEditCollectionArray[index].type = parseInt(e.target.value);
        }

        function renameField(e, i) {
            $globalEditCollectionArray.forEach(function(el, index) {
                if (i === index) {
                    $globalEditCollectionArray[index].name = e.target.value;
                }
            });
        }

        function removeCollectionField(index, id = null) {
            if (id !== null) {
                $globalRemoveField.push({
                    fieldID: id
                });
            }
            $globalEditCollectionArray.splice(index, 1);
            updateEditCollectionState();
        }

        function addNewField() {
            $globalEditCollectionArray.push({
                id: null,
                name: '',
                type: null,
            });
            updateEditCollectionState();
        }

        function saveCollectionEdit() {
            const data = {
                collectionID: $globalSelectedCollection.id,
                originalCollectionName: $globalSelectedCollection.name,
                updatedCollectionName: $globalEditCollectionArray.updatedCollectionName,
                updatedCollection: null,
                removedItems: $globalRemoveField
            };
            delete $globalEditCollectionArray.updatedCollectionName;
            data.updatedCollection = $globalEditCollectionArray;
            console.log(data.removedItems);
            axios.post('/cms/updateCollection', data).then(function(res) {}).catch(function(err) {
                console.log(err);
            });
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

        //THIS FUNCTION AND FUNCTION GETCOLUMNTYPES COULD BE IMPROVED UPON
        function returnInputType(name, type, index) {
            $globalAddEntryArray.push({
                columnName: name,
                value: null
            });
            if (type == 1) {
                return `<input placeholder="${name}" type="text" onchange="updateEntryInput(event, ${index})"></input><br><br>`;
            }

            if (type == 2) {
                return `<input placeholder="${name}" type="text" onchange="updateEntryInput(event, ${index})"></input><br><br>`;
            }

            if (type == 3) {
                return `<input placeholder="${name}" type="text" onchange="updateEntryInput(event, ${index})"></input><br><br>`;
            }

            if (type == 4) {
                return `<input placeholder="${name}" type="text" onchange="updateEntryInput(event, ${index})"></input><br><br>`;
            }

            if (type == 5) {
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
                    //$globalAddEntryArray = [];
                    //if success
                    location.reload();
                }).catch(function(error) {
                    console.log(error);
                });


        }

        ////////////////////////////////////////////////////////////
        //Update/ Edit Entry Modal
        ////////////////////////////////////////////////////////////
        function openEditEntryModal(id, collectionName) {
            collectionModal.style.display = "none";
            editEntryModal.style.display = "block";

            //Get Entry
            let entry = $globalSelectedCollection.data.filter(function(el) {
                return el.id == id;
            });
            entry = entry[0];
            delete entry.id;
            delete entry.created_at;
            delete entry.updated_at;
            $globalUpdateEntry = entry;

            editForm =
                `<button onclick="
            backBtn()
            ">Back</button><br><h1>Entry</h1><button onclick="deleteEntry(${id}, '${collectionName}')" style="float: right" >delete</button><br>`;

            //Create the form
            $globalSelectedCollection.fields.forEach(function(el, index) {
                let columnName = el.name.toLowerCase();
                let columnType = el.type;
                return editForm += getEditEntryType(columnName, columnType, entry[columnName.toLowerCase()], index);
            });
            editForm +=
                `<label for="publish">Published</label><br>
            <input type="checkbox" id="publishedCheck" name="publish" onchange="onchangePublish(event)"><br>`;

            editForm +=
                `<button onclick="updateEntry(${id}, '${collectionName}')">SAVE</button>`;
            document.getElementById("editEntryData").innerHTML = editForm;
            document.getElementById("publishedCheck").checked = entry.published;
        }

        //${JSON.stringify(entry).split('"').join("&quot;")}
        function getEditEntryType(columnName, columnType, value, index) {
            return `<label for="${columnName}">${columnName}</label><br><input name="${columnName}" placeholder="${value}" value="${value}" onchange="updateGlobalUpdateArray(event, '${columnName}')" type="text" /><br><br>`;
        }

        function onchangePublish(e) {
            $globalUpdateEntry.published = e.target.checked;
        }

        function updateGlobalUpdateArray(e, columnName) {
            $globalUpdateEntry[columnName] = e.target.value;
        }

        function updateEntry(id, collectionName) {
            const data = {
                id: id,
                entry: $globalUpdateEntry,
                collectionName: collectionName
            }
            axios.post('/cms/updateEntry', data).then(function(res) {
                location.reload();
                console.log(res);
            }).catch(function(err) {
                console.log(err);
            });
        }

        ////////////////////////////////////////////////////////////
        //All Modals
        ////////////////////////////////////////////////////////////
        closeModals = () => {
            collectionModal.style.display = "none";
            addEntryModal.style.display = "none";
            editCollectionModal.style.display = "none";
            editEntryModal.style.display = "none";
            createCollectionModal.style.display = "none";
        }

        function backBtn() {
            addEntryModal.style.display = "none";
            editCollectionModal.style.display = "none";
            editEntryModal.style.display = "none";
            collectionModal.style.display = "block";
        }

        ////////////////////////////////////////////////////////////
        //Global Helpers
        ////////////////////////////////////////////////////////////
        function getFieldTypes() {
            let types = ``;
            fieldTypes.forEach(function(el) {
                types += `<option value="${el.id}">${el.desc}</option>`
            });
            return types;
        }
    </script>
@endsection
