<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>SearchUsers</title>
</head>

<body>
    <div id="app">
        <div class="position-relative container-fluid">
            <div class="col-12 col-sm-10 offset-sm-1 mt-sm-5 bg-cs-accent p-4 pb-5 rounded-3">
                <h1><i class="fas fa-chalkboard-teacher text-white"></i> <strong>Schul</strong>campus</h1>
                <h3 class="mb-5">Search among the users</h3>
            </div>
            <div id="searchInputDiv" class="col-12 col-sm-6 offset-sm-3 position-absolute d-flex">

                <input @input="autocomplete" v-model="searchInput" class="form-control form-control-lg" type="text"
                    placeholder="Search by given name or family name">

            </div>
            <div v-show="show" v-if="searchInput !== ''" id="autocomplete"
                class="col-12 col-sm-6 offset-sm-3 position-absolute bg-white overflow-auto border border-top-0">
                <ul class="list-unstyled">
                    <li @click="pickUser(user)" class="p-1" v-for="user in users"> @{{ user.familyName + ', ' + user.givenName }}
                    </li>
                    <li class="p-1" v-if="users== '' ">No match</li>
                </ul>
            </div>


        </div>
        <div v-if="selectedUser !== ''" class="container mt-5">
            <h5>User:</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Sourced Id</th>
                        <th>username</th>
                        <th>role</th>
                        <th>status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>@{{ selectedUser.familyName + ', ' + selectedUser.givenName }}</td>
                        <td>@{{ selectedUser.sourcedId }}</td>
                        <td>@{{ selectedUser.username }}</td>
                        <td>@{{ selectedUser.role }}</td>
                        <td>@{{ selectedUser.status }}</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>



    <script src="https://kit.fontawesome.com/2bab0aa439.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
