<?php

namespace App\Http\Controllers;

use App\Models\Ong;
use App\Models\Site;
use App\Models\User;
use Inertia\Inertia;

use Illuminate\Support\Str;
use App\Mail\UserPasswordMail;
use App\Models\SupervisorRight;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $query = User::query();

        if (Auth::user()->role == 'adminONG') {
            $query->where('ong_id', Auth::user()->ong_id)->where('role', '!=', 'adminONG');
        } else if (Auth::user()->role == 'admin') {
            $query->where('role', '!=', 'admin');
        }

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $users = $query->orderBy('id', 'desc')->paginate();

        $users->getCollection()->transform(function ($user) {
            return $user->append('role_label');
        });

        return Inertia::render('App/User/Index', [
            'users' => $users,
            'csrf' => csrf_token(),
            'my_actions' => $this->userActions(),
            'my_attributes' => $this->userColumns(),
            'my_fields' => $this->userFields(),
            'filters' => request('search'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::ulid();

        if (Auth::user()->role == 'adminONG') {
            $data['ong_id'] = Auth::user()->ong_id;
            $data['role'] = 'agent';
            $data['organization'] = Auth::user()->ong->name;
        }

        if (Auth::user()->role == 'admin') {
            $data['ong_id'] = $request->ong_id ?? null;
            $data['role'] = $request->role;
            $data['organization'] = match ($request->role) {
                'adminONG' => Ong::find($request->ong_id)->name,
                default => 'MdT',
            };
        }

        if ($request->picture != null) {
            $name = $data['slug'] . '_pic.' . $request->picture->extension();
            $data['picture'] = $request->picture->storeAs('user', $name, 'public');
        }

        $letters = '';
        for ($i = 65; $i <= 90; $i++) {
            $letters .= chr($i);
        }
        $numbers = '';
        for ($i = 48; $i <= 57; $i++) {
            $numbers .= chr($i);
        }
        $characters = $letters . $numbers;
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $data['password'] = $randomString;

        $user = User::create($data);
        Mail::to($user)->send(new UserPasswordMail($user, $randomString));

        if ($user->role == 'supervisor') {
            SupervisorRight::create([
                'user_id' => $user->id,
                'configurations' => $request->configurations,
                'manage_ongs' => $request->manage_ongs,
                'manage_supervisors' => $request->manage_supervisors,
                'manage_partners' => $request->manage_partners
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if ($user->role == 'supervisor') {
            $user = $user->with('supervisorRight')->first();
        }
        return Inertia::render('App/User/Edit', [
            'user' => $user,
            'csrf' => csrf_token(),
            'my_fields' => $this->userFields(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();

        if ($request->file('picture') != null) {
            try {
                if ($user->picture) {
                    Storage::delete($user->picture);
                }
                $name = $user->id . '_pic.' . $request->picture->extension();
                $data['picture'] = $request->picture->storeAs('user', $name, 'public');
            } catch (\Exception $e) {
                return back();
            }
        }

        try {
            $user->update($data);
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            if ($user->picture != null) {
                Storage::delete($user->picture);
            }
            $user = $user->delete();
            return redirect(route('users.index'));
        } catch (\Exception $e) {
            return back();
        }
    }

    private function userColumns()
    {
        $columns = [
            'picture' => '',
            'name' => 'Nom et prénom',
            'email' => 'Email',
            'contact' => 'Contact',
            'role_label' => 'Role',
        ];

        if (Auth::user()->role == 'admin') {
            $columns['organization'] = 'Organisation';
        }
        return $columns;
    }

    private function userActions()
    {
        $actions = [
            'edit' => "Modifier",
            'delete' => "Supprimer",
        ];
        return $actions;
    }

    private function userFields()
    {
        $fields = [
            'name' => [
                'title' => "Nom et prénom",
                'placeholder' => 'Entrez le nom de l\'utilisateur',
                'field' => 'text',
                'required' => true,
                'required_on_edit' => true,
                'colspan' => false
            ],
            'email' => [
                'title' => "Email",
                'placeholder' => 'Entrez l\'email de l\'utilisateur',
                'field' => 'email',
                'required' => true,
                'required_on_edit' => true,
                'colspan' => false
            ],
            'contact' => [
                'title' => "Contact",
                'placeholder' => 'Entrez le contact de l\'utilisateur',
                'field' => 'tel',
                'required' => true,
                'required_on_edit' => true,
                'colspan' => false
            ],
            'picture' => [
                'title' => "Photo de profil",
                'placeholder' => '',
                'field' => 'file',
                'required' => false,
                'required_on_edit' => false,
                'colspan' => true
            ],
        ];

        if (Auth::user()->role == 'admin') {
            $fields = array_merge(
                [
                    'role' => [
                        'title' => "Role",
                        'placeholder' => 'Sélectionnez un role',
                        'field' => 'select',
                        'required' => true,
                        'required_on_edit' => true,
                        'options' => array_intersect_key(config('global.roles'), array_flip(['guest', 'adminONG', 'partner', 'supervisor'])),
                        'colspan' => false
                    ],
                    'ong_id' => [
                        'title' => "ONG",
                        'placeholder' => 'Sélectionnez une ONG',
                        'field' => 'model',
                        'required' => true,
                        'required_on_edit' => true,
                        'options' => Ong::select('id', 'name')->get(),
                        'colspan' => false
                    ],
                ],
                $fields
            );
        }

        if (Auth::user()->role == 'admin') {
            $fields['configurations'] = [
                'title' => "Le superviseur peut ajouter/modifier/supprimer des configurations",
                'placeholder' => '',
                'field' => 'checkbox',
                'required' => false,
                'required_on_edit' => false,
                'colspan' => true,
                'displayValue' => 'supervisor',
                'watcher' => 'role'
            ];
            $fields['manage_ongs'] = [
                'title' => "Le superviseur peut ajouter/modifier/supprimer des ONGs",
                'placeholder' => '',
                'field' => 'checkbox',
                'required' => false,
                'required_on_edit' => false,
                'colspan' => true,
                'displayValue' => 'supervisor',
                'watcher' => 'role'
            ];
            $fields['manage_supervisors'] = [
                'title' => "Le superviseur peut ajouter/modifier/supprimer des superviseurs",
                'placeholder' => '',
                'field' => 'checkbox',
                'required' => false,
                'required_on_edit' => false,
                'colspan' => true,
                'displayValue' => 'supervisor',
                'watcher' => 'role'
            ];
            $fields['manage_partners'] = [
                'title' => "Le superviseur peut ajouter/modifier/supprimer des partenaires et invités",
                'placeholder' => '',
                'field' => 'checkbox',
                'required' => false,
                'required_on_edit' => false,
                'colspan' => true,
                'displayValue' => 'supervisor',
                'watcher' => 'role'
            ];
        }

        if (Auth::user()->role == 'adminONG') {
            $fields = array_merge(
                [
                    'site_id' => [
                        'title' => "Site",
                        'placeholder' => 'Sélectionnez un site',
                        'field' => 'model',
                        'required' => true,
                        'required_on_edit' => true,
                        'options' => Site::select('id', 'name')->where('ong_id', Auth::user()->ong_id)->get(),
                        'colspan' => false
                    ],
                ],
                $fields
            );
        }

        return $fields;
    }
}
