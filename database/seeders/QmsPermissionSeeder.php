<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class QmsPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // Dashboard
            'dashboard.view',

            // Clause 4 - Context
            'qms-context.view',
            'qms-context.create',
            'qms-context.update',
            'qms-context.delete',

            // Clause 5 - Leadership
            'quality-policy.view',
            'quality-policy.create',
            'quality-policy.update',
            'quality-policy.delete',

            // Processes
            'processes.view',
            'processes.create',
            'processes.update',
            'processes.delete',
            'processes.approve',

            // Documents
            'documents.view',
            'documents.create',
            'documents.update',
            'documents.delete',
            'documents.upload',
            'documents.download',
            'documents.submit',
            'documents.review',
            'documents.approve',
            'documents.publish',
            'documents.archive',

            // Document versions
            'document-versions.view',
            'document-versions.create',
            'document-versions.update',

            // Records
            'records.view',
            'records.create',
            'records.update',
            'records.delete',
            'records.archive',

            // Risks & Opportunities
            'risks.view',
            'risks.create',
            'risks.update',
            'risks.delete',
            'risks.review',

            // Quality Objectives
            'quality-objectives.view',
            'quality-objectives.create',
            'quality-objectives.update',
            'quality-objectives.delete',

            // Training
            'training.view',
            'training.create',
            'training.update',
            'training.delete',

            // Audits
            'audits.view',
            'audits.create',
            'audits.update',
            'audits.delete',
            'audits.conduct',

            // Audit Findings
            'audit-findings.view',
            'audit-findings.create',
            'audit-findings.update',
            'audit-findings.close',

            // Nonconformities
            'nonconformities.view',
            'nonconformities.create',
            'nonconformities.update',
            'nonconformities.delete',
            'nonconformities.close',

            // Corrective Actions
            'corrective-actions.view',
            'corrective-actions.create',
            'corrective-actions.update',
            'corrective-actions.close',

            // Management Review
            'management-review.view',
            'management-review.create',
            'management-review.update',
            'management-review.approve',

            // Reports
            'reports.view',
            'reports.export',

            // Audit Trail
            'audit-trail.view',

            // Users
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'users.assign-role',

            // Roles
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',

            // Permissions
            'permissions.view',
            'permissions.create',
            'permissions.update',
            'permissions.delete',

            // Backup
            'backup.view',
            'backup.create',
            'backup.download',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        $qmr = Role::firstOrCreate([
            'name' => 'QMR',
            'guard_name' => 'web',
        ]);

        $documentController = Role::firstOrCreate([
            'name' => 'Document Controller',
            'guard_name' => 'web',
        ]);

        $processOwner = Role::firstOrCreate([
            'name' => 'Process Owner',
            'guard_name' => 'web',
        ]);

        $departmentQmsOfficer = Role::firstOrCreate([
            'name' => 'Department QMS Officer',
            'guard_name' => 'web',
        ]);

        $internalAuditor = Role::firstOrCreate([
            'name' => 'Internal Auditor',
            'guard_name' => 'web',
        ]);

        $topManagement = Role::firstOrCreate([
            'name' => 'Top Management',
            'guard_name' => 'web',
        ]);

        $qmsUser = Role::firstOrCreate([
            'name' => 'QMS User',
            'guard_name' => 'web',
        ]);

        $qmsViewer = Role::firstOrCreate([
            'name' => 'QMS Viewer',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        */

        $superAdmin->syncPermissions(
            Permission::all()
        );

        /*
        |--------------------------------------------------------------------------
        | QMR
        |--------------------------------------------------------------------------
        */

        $qmr->syncPermissions([
            'dashboard.view',

            'qms-context.view',
            'qms-context.create',
            'qms-context.update',

            'quality-policy.view',
            'quality-policy.create',
            'quality-policy.update',

            'processes.view',
            'processes.create',
            'processes.update',
            'processes.approve',

            'documents.view',
            'documents.create',
            'documents.update',
            'documents.upload',
            'documents.download',
            'documents.submit',
            'documents.review',
            'documents.approve',
            'documents.publish',
            'documents.archive',

            'document-versions.view',
            'document-versions.create',
            'document-versions.update',

            'records.view',
            'records.create',
            'records.update',
            'records.archive',

            'risks.view',
            'risks.create',
            'risks.update',
            'risks.review',

            'quality-objectives.view',
            'quality-objectives.create',
            'quality-objectives.update',

            'training.view',
            'training.create',
            'training.update',

            'audits.view',
            'audits.create',
            'audits.update',
            'audits.conduct',

            'audit-findings.view',
            'audit-findings.create',
            'audit-findings.update',
            'audit-findings.close',

            'nonconformities.view',
            'nonconformities.create',
            'nonconformities.update',
            'nonconformities.close',

            'corrective-actions.view',
            'corrective-actions.create',
            'corrective-actions.update',
            'corrective-actions.close',

            'management-review.view',
            'management-review.create',
            'management-review.update',
            'management-review.approve',

            'reports.view',
            'reports.export',

            'audit-trail.view',

            'users.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Document Controller
        |--------------------------------------------------------------------------
        */

        $documentController->syncPermissions([
            'dashboard.view',

            'documents.view',
            'documents.create',
            'documents.update',
            'documents.upload',
            'documents.download',
            'documents.submit',

            'document-versions.view',
            'document-versions.create',
            'document-versions.update',

            'records.view',
            'records.create',
            'records.update',

            'reports.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Process Owner
        |--------------------------------------------------------------------------
        */

        $processOwner->syncPermissions([
            'dashboard.view',

            'processes.view',
            'processes.create',
            'processes.update',

            'documents.view',
            'documents.create',
            'documents.upload',
            'documents.download',
            'documents.submit',

            'records.view',
            'records.create',
            'records.update',

            'risks.view',
            'risks.create',
            'risks.update',

            'quality-objectives.view',
            'quality-objectives.create',
            'quality-objectives.update',

            'nonconformities.view',
            'nonconformities.create',

            'corrective-actions.view',
            'corrective-actions.create',
            'corrective-actions.update',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Department QMS Officer
        |--------------------------------------------------------------------------
        */

        $departmentQmsOfficer->syncPermissions([
            'dashboard.view',

            'documents.view',
            'documents.create',
            'documents.upload',
            'documents.download',
            'documents.submit',

            'records.view',
            'records.create',
            'records.update',

            'risks.view',
            'risks.create',
            'risks.update',

            'quality-objectives.view',
            'quality-objectives.update',

            'nonconformities.view',
            'nonconformities.create',
            'nonconformities.update',

            'corrective-actions.view',
            'corrective-actions.create',
            'corrective-actions.update',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Internal Auditor
        |--------------------------------------------------------------------------
        */

        $internalAuditor->syncPermissions([
            'dashboard.view',

            'documents.view',
            'documents.download',

            'processes.view',
            'records.view',

            'risks.view',

            'audits.view',
            'audits.create',
            'audits.update',
            'audits.conduct',

            'audit-findings.view',
            'audit-findings.create',
            'audit-findings.update',

            'nonconformities.view',
            'nonconformities.create',
            'nonconformities.update',

            'corrective-actions.view',
            'corrective-actions.update',

            'reports.view',
            'reports.export',

            'audit-trail.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Top Management
        |--------------------------------------------------------------------------
        */

        $topManagement->syncPermissions([
            'dashboard.view',

            'qms-context.view',
            'quality-policy.view',

            'processes.view',

            'documents.view',
            'documents.download',

            'records.view',

            'risks.view',

            'quality-objectives.view',

            'audits.view',

            'audit-findings.view',

            'nonconformities.view',

            'corrective-actions.view',

            'management-review.view',
            'management-review.create',
            'management-review.update',
            'management-review.approve',

            'reports.view',
            'reports.export',
        ]);

        /*
        |--------------------------------------------------------------------------
        | QMS User
        |--------------------------------------------------------------------------
        */

        $qmsUser->syncPermissions([
            'dashboard.view',

            'documents.view',
            'documents.download',

            'processes.view',
            'records.view',
            'risks.view',
            'quality-objectives.view',

            'audits.view',
            'nonconformities.view',
            'corrective-actions.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | QMS Viewer
        |--------------------------------------------------------------------------
        */

        $qmsViewer->syncPermissions([
            'dashboard.view',
            'documents.view',
            'documents.download',
            'processes.view',
            'records.view',
        ]);
    }
}
