<?php


/**
 * Base class that represents a query for the 'users' table.
 *
 *
 *
 * @method UserQuery orderById($order = Criteria::ASC) Order by the id column
 * @method UserQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method UserQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method UserQuery orderByDigestHA1($order = Criteria::ASC) Order by the digest_ha1 column
 * @method UserQuery orderByFirstName($order = Criteria::ASC) Order by the first_name column
 * @method UserQuery orderByLastName($order = Criteria::ASC) Order by the last_name column
 * @method UserQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method UserQuery orderByLanguageId($order = Criteria::ASC) Order by the language_id column
 * @method UserQuery orderByIsAdmin($order = Criteria::ASC) Order by the is_admin column
 * @method UserQuery orderByIsBackendLoginEnabled($order = Criteria::ASC) Order by the is_backend_login_enabled column
 * @method UserQuery orderByIsAdminLoginEnabled($order = Criteria::ASC) Order by the is_admin_login_enabled column
 * @method UserQuery orderByIsInactive($order = Criteria::ASC) Order by the is_inactive column
 * @method UserQuery orderByPasswordRecoverHint($order = Criteria::ASC) Order by the password_recover_hint column
 * @method UserQuery orderByBackendSettings($order = Criteria::ASC) Order by the backend_settings column
 * @method UserQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method UserQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method UserQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method UserQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method UserQuery groupById() Group by the id column
 * @method UserQuery groupByUsername() Group by the username column
 * @method UserQuery groupByPassword() Group by the password column
 * @method UserQuery groupByDigestHA1() Group by the digest_ha1 column
 * @method UserQuery groupByFirstName() Group by the first_name column
 * @method UserQuery groupByLastName() Group by the last_name column
 * @method UserQuery groupByEmail() Group by the email column
 * @method UserQuery groupByLanguageId() Group by the language_id column
 * @method UserQuery groupByIsAdmin() Group by the is_admin column
 * @method UserQuery groupByIsBackendLoginEnabled() Group by the is_backend_login_enabled column
 * @method UserQuery groupByIsAdminLoginEnabled() Group by the is_admin_login_enabled column
 * @method UserQuery groupByIsInactive() Group by the is_inactive column
 * @method UserQuery groupByPasswordRecoverHint() Group by the password_recover_hint column
 * @method UserQuery groupByBackendSettings() Group by the backend_settings column
 * @method UserQuery groupByCreatedAt() Group by the created_at column
 * @method UserQuery groupByUpdatedAt() Group by the updated_at column
 * @method UserQuery groupByCreatedBy() Group by the created_by column
 * @method UserQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method UserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method UserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method UserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method UserQuery leftJoinLanguageRelatedByLanguageId($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageRelatedByLanguageId relation
 * @method UserQuery rightJoinLanguageRelatedByLanguageId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageRelatedByLanguageId relation
 * @method UserQuery innerJoinLanguageRelatedByLanguageId($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageRelatedByLanguageId relation
 *
 * @method UserQuery leftJoinUserGroupRelatedByUserId($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserGroupRelatedByUserId relation
 * @method UserQuery rightJoinUserGroupRelatedByUserId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserGroupRelatedByUserId relation
 * @method UserQuery innerJoinUserGroupRelatedByUserId($relationAlias = null) Adds a INNER JOIN clause to the query using the UserGroupRelatedByUserId relation
 *
 * @method UserQuery leftJoinUserRoleRelatedByUserId($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRoleRelatedByUserId relation
 * @method UserQuery rightJoinUserRoleRelatedByUserId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRoleRelatedByUserId relation
 * @method UserQuery innerJoinUserRoleRelatedByUserId($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRoleRelatedByUserId relation
 *
 * @method UserQuery leftJoinDocumentRelatedByOwnerId($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentRelatedByOwnerId relation
 * @method UserQuery rightJoinDocumentRelatedByOwnerId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentRelatedByOwnerId relation
 * @method UserQuery innerJoinDocumentRelatedByOwnerId($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentRelatedByOwnerId relation
 *
 * @method UserQuery leftJoinLinkRelatedByOwnerId($relationAlias = null) Adds a LEFT JOIN clause to the query using the LinkRelatedByOwnerId relation
 * @method UserQuery rightJoinLinkRelatedByOwnerId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LinkRelatedByOwnerId relation
 * @method UserQuery innerJoinLinkRelatedByOwnerId($relationAlias = null) Adds a INNER JOIN clause to the query using the LinkRelatedByOwnerId relation
 *
 * @method UserQuery leftJoinPageRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageRelatedByCreatedBy relation
 * @method UserQuery rightJoinPageRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageRelatedByCreatedBy relation
 * @method UserQuery innerJoinPageRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PageRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinPageRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageRelatedByUpdatedBy relation
 * @method UserQuery rightJoinPageRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageRelatedByUpdatedBy relation
 * @method UserQuery innerJoinPageRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PageRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinPagePropertyRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PagePropertyRelatedByCreatedBy relation
 * @method UserQuery rightJoinPagePropertyRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PagePropertyRelatedByCreatedBy relation
 * @method UserQuery innerJoinPagePropertyRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PagePropertyRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinPagePropertyRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PagePropertyRelatedByUpdatedBy relation
 * @method UserQuery rightJoinPagePropertyRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PagePropertyRelatedByUpdatedBy relation
 * @method UserQuery innerJoinPagePropertyRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PagePropertyRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinPageStringRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageStringRelatedByCreatedBy relation
 * @method UserQuery rightJoinPageStringRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageStringRelatedByCreatedBy relation
 * @method UserQuery innerJoinPageStringRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PageStringRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinPageStringRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageStringRelatedByUpdatedBy relation
 * @method UserQuery rightJoinPageStringRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageStringRelatedByUpdatedBy relation
 * @method UserQuery innerJoinPageStringRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PageStringRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinContentObjectRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentObjectRelatedByCreatedBy relation
 * @method UserQuery rightJoinContentObjectRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentObjectRelatedByCreatedBy relation
 * @method UserQuery innerJoinContentObjectRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentObjectRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinContentObjectRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentObjectRelatedByUpdatedBy relation
 * @method UserQuery rightJoinContentObjectRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentObjectRelatedByUpdatedBy relation
 * @method UserQuery innerJoinContentObjectRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentObjectRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinLanguageObjectRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageObjectRelatedByCreatedBy relation
 * @method UserQuery rightJoinLanguageObjectRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageObjectRelatedByCreatedBy relation
 * @method UserQuery innerJoinLanguageObjectRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageObjectRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinLanguageObjectRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageObjectRelatedByUpdatedBy relation
 * @method UserQuery rightJoinLanguageObjectRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageObjectRelatedByUpdatedBy relation
 * @method UserQuery innerJoinLanguageObjectRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageObjectRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinLanguageObjectHistoryRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageObjectHistoryRelatedByCreatedBy relation
 * @method UserQuery rightJoinLanguageObjectHistoryRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageObjectHistoryRelatedByCreatedBy relation
 * @method UserQuery innerJoinLanguageObjectHistoryRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageObjectHistoryRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinLanguageObjectHistoryRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageObjectHistoryRelatedByUpdatedBy relation
 * @method UserQuery rightJoinLanguageObjectHistoryRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageObjectHistoryRelatedByUpdatedBy relation
 * @method UserQuery innerJoinLanguageObjectHistoryRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageObjectHistoryRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinLanguageRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageRelatedByCreatedBy relation
 * @method UserQuery rightJoinLanguageRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageRelatedByCreatedBy relation
 * @method UserQuery innerJoinLanguageRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinLanguageRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageRelatedByUpdatedBy relation
 * @method UserQuery rightJoinLanguageRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageRelatedByUpdatedBy relation
 * @method UserQuery innerJoinLanguageRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinStringRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the StringRelatedByCreatedBy relation
 * @method UserQuery rightJoinStringRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StringRelatedByCreatedBy relation
 * @method UserQuery innerJoinStringRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the StringRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinStringRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the StringRelatedByUpdatedBy relation
 * @method UserQuery rightJoinStringRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StringRelatedByUpdatedBy relation
 * @method UserQuery innerJoinStringRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the StringRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinUserGroupRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserGroupRelatedByCreatedBy relation
 * @method UserQuery rightJoinUserGroupRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserGroupRelatedByCreatedBy relation
 * @method UserQuery innerJoinUserGroupRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserGroupRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinUserGroupRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserGroupRelatedByUpdatedBy relation
 * @method UserQuery rightJoinUserGroupRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserGroupRelatedByUpdatedBy relation
 * @method UserQuery innerJoinUserGroupRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserGroupRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinGroupRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupRelatedByCreatedBy relation
 * @method UserQuery rightJoinGroupRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupRelatedByCreatedBy relation
 * @method UserQuery innerJoinGroupRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinGroupRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupRelatedByUpdatedBy relation
 * @method UserQuery rightJoinGroupRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupRelatedByUpdatedBy relation
 * @method UserQuery innerJoinGroupRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinGroupRoleRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupRoleRelatedByCreatedBy relation
 * @method UserQuery rightJoinGroupRoleRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupRoleRelatedByCreatedBy relation
 * @method UserQuery innerJoinGroupRoleRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupRoleRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinGroupRoleRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupRoleRelatedByUpdatedBy relation
 * @method UserQuery rightJoinGroupRoleRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupRoleRelatedByUpdatedBy relation
 * @method UserQuery innerJoinGroupRoleRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupRoleRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinRoleRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the RoleRelatedByCreatedBy relation
 * @method UserQuery rightJoinRoleRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RoleRelatedByCreatedBy relation
 * @method UserQuery innerJoinRoleRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the RoleRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinRoleRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the RoleRelatedByUpdatedBy relation
 * @method UserQuery rightJoinRoleRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RoleRelatedByUpdatedBy relation
 * @method UserQuery innerJoinRoleRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the RoleRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinUserRoleRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRoleRelatedByCreatedBy relation
 * @method UserQuery rightJoinUserRoleRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRoleRelatedByCreatedBy relation
 * @method UserQuery innerJoinUserRoleRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRoleRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinUserRoleRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRoleRelatedByUpdatedBy relation
 * @method UserQuery rightJoinUserRoleRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRoleRelatedByUpdatedBy relation
 * @method UserQuery innerJoinUserRoleRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRoleRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinRightRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the RightRelatedByCreatedBy relation
 * @method UserQuery rightJoinRightRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RightRelatedByCreatedBy relation
 * @method UserQuery innerJoinRightRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the RightRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinRightRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the RightRelatedByUpdatedBy relation
 * @method UserQuery rightJoinRightRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RightRelatedByUpdatedBy relation
 * @method UserQuery innerJoinRightRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the RightRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinDocumentRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentRelatedByCreatedBy relation
 * @method UserQuery rightJoinDocumentRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentRelatedByCreatedBy relation
 * @method UserQuery innerJoinDocumentRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinDocumentRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentRelatedByUpdatedBy relation
 * @method UserQuery rightJoinDocumentRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentRelatedByUpdatedBy relation
 * @method UserQuery innerJoinDocumentRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinDocumentTypeRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentTypeRelatedByCreatedBy relation
 * @method UserQuery rightJoinDocumentTypeRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentTypeRelatedByCreatedBy relation
 * @method UserQuery innerJoinDocumentTypeRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentTypeRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinDocumentTypeRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentTypeRelatedByUpdatedBy relation
 * @method UserQuery rightJoinDocumentTypeRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentTypeRelatedByUpdatedBy relation
 * @method UserQuery innerJoinDocumentTypeRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentTypeRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinDocumentCategoryRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentCategoryRelatedByCreatedBy relation
 * @method UserQuery rightJoinDocumentCategoryRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentCategoryRelatedByCreatedBy relation
 * @method UserQuery innerJoinDocumentCategoryRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentCategoryRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinDocumentCategoryRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentCategoryRelatedByUpdatedBy relation
 * @method UserQuery rightJoinDocumentCategoryRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentCategoryRelatedByUpdatedBy relation
 * @method UserQuery innerJoinDocumentCategoryRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentCategoryRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinTagRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TagRelatedByCreatedBy relation
 * @method UserQuery rightJoinTagRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TagRelatedByCreatedBy relation
 * @method UserQuery innerJoinTagRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TagRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinTagRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TagRelatedByUpdatedBy relation
 * @method UserQuery rightJoinTagRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TagRelatedByUpdatedBy relation
 * @method UserQuery innerJoinTagRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TagRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinTagInstanceRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TagInstanceRelatedByCreatedBy relation
 * @method UserQuery rightJoinTagInstanceRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TagInstanceRelatedByCreatedBy relation
 * @method UserQuery innerJoinTagInstanceRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TagInstanceRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinTagInstanceRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TagInstanceRelatedByUpdatedBy relation
 * @method UserQuery rightJoinTagInstanceRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TagInstanceRelatedByUpdatedBy relation
 * @method UserQuery innerJoinTagInstanceRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TagInstanceRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinLinkRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LinkRelatedByCreatedBy relation
 * @method UserQuery rightJoinLinkRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LinkRelatedByCreatedBy relation
 * @method UserQuery innerJoinLinkRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LinkRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinLinkRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LinkRelatedByUpdatedBy relation
 * @method UserQuery rightJoinLinkRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LinkRelatedByUpdatedBy relation
 * @method UserQuery innerJoinLinkRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LinkRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinLinkCategoryRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LinkCategoryRelatedByCreatedBy relation
 * @method UserQuery rightJoinLinkCategoryRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LinkCategoryRelatedByCreatedBy relation
 * @method UserQuery innerJoinLinkCategoryRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LinkCategoryRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinLinkCategoryRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LinkCategoryRelatedByUpdatedBy relation
 * @method UserQuery rightJoinLinkCategoryRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LinkCategoryRelatedByUpdatedBy relation
 * @method UserQuery innerJoinLinkCategoryRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LinkCategoryRelatedByUpdatedBy relation
 *
 * @method UserQuery leftJoinReferenceRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the ReferenceRelatedByCreatedBy relation
 * @method UserQuery rightJoinReferenceRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ReferenceRelatedByCreatedBy relation
 * @method UserQuery innerJoinReferenceRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the ReferenceRelatedByCreatedBy relation
 *
 * @method UserQuery leftJoinReferenceRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the ReferenceRelatedByUpdatedBy relation
 * @method UserQuery rightJoinReferenceRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ReferenceRelatedByUpdatedBy relation
 * @method UserQuery innerJoinReferenceRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the ReferenceRelatedByUpdatedBy relation
 *
 * @method User findOne(PropelPDO $con = null) Return the first User matching the query
 * @method User findOneOrCreate(PropelPDO $con = null) Return the first User matching the query, or a new User object populated from the query conditions when no match is found
 *
 * @method User findOneByUsername(string $username) Return the first User filtered by the username column
 * @method User findOneByPassword(string $password) Return the first User filtered by the password column
 * @method User findOneByDigestHA1(string $digest_ha1) Return the first User filtered by the digest_ha1 column
 * @method User findOneByFirstName(string $first_name) Return the first User filtered by the first_name column
 * @method User findOneByLastName(string $last_name) Return the first User filtered by the last_name column
 * @method User findOneByEmail(string $email) Return the first User filtered by the email column
 * @method User findOneByLanguageId(string $language_id) Return the first User filtered by the language_id column
 * @method User findOneByIsAdmin(boolean $is_admin) Return the first User filtered by the is_admin column
 * @method User findOneByIsBackendLoginEnabled(boolean $is_backend_login_enabled) Return the first User filtered by the is_backend_login_enabled column
 * @method User findOneByIsAdminLoginEnabled(boolean $is_admin_login_enabled) Return the first User filtered by the is_admin_login_enabled column
 * @method User findOneByIsInactive(boolean $is_inactive) Return the first User filtered by the is_inactive column
 * @method User findOneByPasswordRecoverHint(string $password_recover_hint) Return the first User filtered by the password_recover_hint column
 * @method User findOneByBackendSettings(resource $backend_settings) Return the first User filtered by the backend_settings column
 * @method User findOneByCreatedAt(string $created_at) Return the first User filtered by the created_at column
 * @method User findOneByUpdatedAt(string $updated_at) Return the first User filtered by the updated_at column
 * @method User findOneByCreatedBy(int $created_by) Return the first User filtered by the created_by column
 * @method User findOneByUpdatedBy(int $updated_by) Return the first User filtered by the updated_by column
 *
 * @method array findById(int $id) Return User objects filtered by the id column
 * @method array findByUsername(string $username) Return User objects filtered by the username column
 * @method array findByPassword(string $password) Return User objects filtered by the password column
 * @method array findByDigestHA1(string $digest_ha1) Return User objects filtered by the digest_ha1 column
 * @method array findByFirstName(string $first_name) Return User objects filtered by the first_name column
 * @method array findByLastName(string $last_name) Return User objects filtered by the last_name column
 * @method array findByEmail(string $email) Return User objects filtered by the email column
 * @method array findByLanguageId(string $language_id) Return User objects filtered by the language_id column
 * @method array findByIsAdmin(boolean $is_admin) Return User objects filtered by the is_admin column
 * @method array findByIsBackendLoginEnabled(boolean $is_backend_login_enabled) Return User objects filtered by the is_backend_login_enabled column
 * @method array findByIsAdminLoginEnabled(boolean $is_admin_login_enabled) Return User objects filtered by the is_admin_login_enabled column
 * @method array findByIsInactive(boolean $is_inactive) Return User objects filtered by the is_inactive column
 * @method array findByPasswordRecoverHint(string $password_recover_hint) Return User objects filtered by the password_recover_hint column
 * @method array findByBackendSettings(resource $backend_settings) Return User objects filtered by the backend_settings column
 * @method array findByCreatedAt(string $created_at) Return User objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return User objects filtered by the updated_at column
 * @method array findByCreatedBy(int $created_by) Return User objects filtered by the created_by column
 * @method array findByUpdatedBy(int $updated_by) Return User objects filtered by the updated_by column
 *
 * @package    propel.generator.model.om
 */
abstract class BaseUserQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseUserQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'rapila', $modelName = 'User', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new UserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   UserQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return UserQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof UserQuery) {
            return $criteria;
        }
        $query = new UserQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   User|User[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UserPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(UserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 User A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 User A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `username`, `password`, `digest_ha1`, `first_name`, `last_name`, `email`, `language_id`, `is_admin`, `is_backend_login_enabled`, `is_admin_login_enabled`, `is_inactive`, `password_recover_hint`, `backend_settings`, `created_at`, `updated_at`, `created_by`, `updated_by` FROM `users` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new User();
            $obj->hydrate($row);
            UserPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return User|User[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|User[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UserPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UserPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%'); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $username)) {
                $username = str_replace('*', '%', $username);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%'); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $password)) {
                $password = str_replace('*', '%', $password);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the digest_ha1 column
     *
     * Example usage:
     * <code>
     * $query->filterByDigestHA1('fooValue');   // WHERE digest_ha1 = 'fooValue'
     * $query->filterByDigestHA1('%fooValue%'); // WHERE digest_ha1 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $digestHA1 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByDigestHA1($digestHA1 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($digestHA1)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $digestHA1)) {
                $digestHA1 = str_replace('*', '%', $digestHA1);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::DIGEST_HA1, $digestHA1, $comparison);
    }

    /**
     * Filter the query on the first_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstName('fooValue');   // WHERE first_name = 'fooValue'
     * $query->filterByFirstName('%fooValue%'); // WHERE first_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByFirstName($firstName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $firstName)) {
                $firstName = str_replace('*', '%', $firstName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::FIRST_NAME, $firstName, $comparison);
    }

    /**
     * Filter the query on the last_name column
     *
     * Example usage:
     * <code>
     * $query->filterByLastName('fooValue');   // WHERE last_name = 'fooValue'
     * $query->filterByLastName('%fooValue%'); // WHERE last_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByLastName($lastName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lastName)) {
                $lastName = str_replace('*', '%', $lastName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::LAST_NAME, $lastName, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the language_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLanguageId('fooValue');   // WHERE language_id = 'fooValue'
     * $query->filterByLanguageId('%fooValue%'); // WHERE language_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $languageId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByLanguageId($languageId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($languageId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $languageId)) {
                $languageId = str_replace('*', '%', $languageId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::LANGUAGE_ID, $languageId, $comparison);
    }

    /**
     * Filter the query on the is_admin column
     *
     * Example usage:
     * <code>
     * $query->filterByIsAdmin(true); // WHERE is_admin = true
     * $query->filterByIsAdmin('yes'); // WHERE is_admin = true
     * </code>
     *
     * @param     boolean|string $isAdmin The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByIsAdmin($isAdmin = null, $comparison = null)
    {
        if (is_string($isAdmin)) {
            $isAdmin = in_array(strtolower($isAdmin), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserPeer::IS_ADMIN, $isAdmin, $comparison);
    }

    /**
     * Filter the query on the is_backend_login_enabled column
     *
     * Example usage:
     * <code>
     * $query->filterByIsBackendLoginEnabled(true); // WHERE is_backend_login_enabled = true
     * $query->filterByIsBackendLoginEnabled('yes'); // WHERE is_backend_login_enabled = true
     * </code>
     *
     * @param     boolean|string $isBackendLoginEnabled The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByIsBackendLoginEnabled($isBackendLoginEnabled = null, $comparison = null)
    {
        if (is_string($isBackendLoginEnabled)) {
            $isBackendLoginEnabled = in_array(strtolower($isBackendLoginEnabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserPeer::IS_BACKEND_LOGIN_ENABLED, $isBackendLoginEnabled, $comparison);
    }

    /**
     * Filter the query on the is_admin_login_enabled column
     *
     * Example usage:
     * <code>
     * $query->filterByIsAdminLoginEnabled(true); // WHERE is_admin_login_enabled = true
     * $query->filterByIsAdminLoginEnabled('yes'); // WHERE is_admin_login_enabled = true
     * </code>
     *
     * @param     boolean|string $isAdminLoginEnabled The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByIsAdminLoginEnabled($isAdminLoginEnabled = null, $comparison = null)
    {
        if (is_string($isAdminLoginEnabled)) {
            $isAdminLoginEnabled = in_array(strtolower($isAdminLoginEnabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserPeer::IS_ADMIN_LOGIN_ENABLED, $isAdminLoginEnabled, $comparison);
    }

    /**
     * Filter the query on the is_inactive column
     *
     * Example usage:
     * <code>
     * $query->filterByIsInactive(true); // WHERE is_inactive = true
     * $query->filterByIsInactive('yes'); // WHERE is_inactive = true
     * </code>
     *
     * @param     boolean|string $isInactive The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByIsInactive($isInactive = null, $comparison = null)
    {
        if (is_string($isInactive)) {
            $isInactive = in_array(strtolower($isInactive), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserPeer::IS_INACTIVE, $isInactive, $comparison);
    }

    /**
     * Filter the query on the password_recover_hint column
     *
     * Example usage:
     * <code>
     * $query->filterByPasswordRecoverHint('fooValue');   // WHERE password_recover_hint = 'fooValue'
     * $query->filterByPasswordRecoverHint('%fooValue%'); // WHERE password_recover_hint LIKE '%fooValue%'
     * </code>
     *
     * @param     string $passwordRecoverHint The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByPasswordRecoverHint($passwordRecoverHint = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($passwordRecoverHint)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $passwordRecoverHint)) {
                $passwordRecoverHint = str_replace('*', '%', $passwordRecoverHint);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserPeer::PASSWORD_RECOVER_HINT, $passwordRecoverHint, $comparison);
    }

    /**
     * Filter the query on the backend_settings column
     *
     * @param     mixed $backendSettings The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByBackendSettings($backendSettings = null, $comparison = null)
    {

        return $this->addUsingAlias(UserPeer::BACKEND_SETTINGS, $backendSettings, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UserPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UserPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(UserPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(UserPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query on the created_by column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedBy(1234); // WHERE created_by = 1234
     * $query->filterByCreatedBy(array(12, 34)); // WHERE created_by IN (12, 34)
     * $query->filterByCreatedBy(array('min' => 12)); // WHERE created_by >= 12
     * $query->filterByCreatedBy(array('max' => 12)); // WHERE created_by <= 12
     * </code>
     *
     * @param     mixed $createdBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(UserPeer::CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(UserPeer::CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::CREATED_BY, $createdBy, $comparison);
    }

    /**
     * Filter the query on the updated_by column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedBy(1234); // WHERE updated_by = 1234
     * $query->filterByUpdatedBy(array(12, 34)); // WHERE updated_by IN (12, 34)
     * $query->filterByUpdatedBy(array('min' => 12)); // WHERE updated_by >= 12
     * $query->filterByUpdatedBy(array('max' => 12)); // WHERE updated_by <= 12
     * </code>
     *
     * @param     mixed $updatedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function filterByUpdatedBy($updatedBy = null, $comparison = null)
    {
        if (is_array($updatedBy)) {
            $useMinMax = false;
            if (isset($updatedBy['min'])) {
                $this->addUsingAlias(UserPeer::UPDATED_BY, $updatedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedBy['max'])) {
                $this->addUsingAlias(UserPeer::UPDATED_BY, $updatedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserPeer::UPDATED_BY, $updatedBy, $comparison);
    }

    /**
     * Filter the query by a related Language object
     *
     * @param   Language|PropelObjectCollection $language The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLanguageRelatedByLanguageId($language, $comparison = null)
    {
        if ($language instanceof Language) {
            return $this
                ->addUsingAlias(UserPeer::LANGUAGE_ID, $language->getId(), $comparison);
        } elseif ($language instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserPeer::LANGUAGE_ID, $language->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByLanguageRelatedByLanguageId() only accepts arguments of type Language or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LanguageRelatedByLanguageId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinLanguageRelatedByLanguageId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LanguageRelatedByLanguageId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'LanguageRelatedByLanguageId');
        }

        return $this;
    }

    /**
     * Use the LanguageRelatedByLanguageId relation Language object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   LanguageQuery A secondary query class using the current class as primary query
     */
    public function useLanguageRelatedByLanguageIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLanguageRelatedByLanguageId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LanguageRelatedByLanguageId', 'LanguageQuery');
    }

    /**
     * Filter the query by a related UserGroup object
     *
     * @param   UserGroup|PropelObjectCollection $userGroup  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserGroupRelatedByUserId($userGroup, $comparison = null)
    {
        if ($userGroup instanceof UserGroup) {
            return $this
                ->addUsingAlias(UserPeer::ID, $userGroup->getUserId(), $comparison);
        } elseif ($userGroup instanceof PropelObjectCollection) {
            return $this
                ->useUserGroupRelatedByUserIdQuery()
                ->filterByPrimaryKeys($userGroup->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserGroupRelatedByUserId() only accepts arguments of type UserGroup or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserGroupRelatedByUserId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinUserGroupRelatedByUserId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserGroupRelatedByUserId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserGroupRelatedByUserId');
        }

        return $this;
    }

    /**
     * Use the UserGroupRelatedByUserId relation UserGroup object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   UserGroupQuery A secondary query class using the current class as primary query
     */
    public function useUserGroupRelatedByUserIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserGroupRelatedByUserId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserGroupRelatedByUserId', 'UserGroupQuery');
    }

    /**
     * Filter the query by a related UserRole object
     *
     * @param   UserRole|PropelObjectCollection $userRole  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserRoleRelatedByUserId($userRole, $comparison = null)
    {
        if ($userRole instanceof UserRole) {
            return $this
                ->addUsingAlias(UserPeer::ID, $userRole->getUserId(), $comparison);
        } elseif ($userRole instanceof PropelObjectCollection) {
            return $this
                ->useUserRoleRelatedByUserIdQuery()
                ->filterByPrimaryKeys($userRole->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserRoleRelatedByUserId() only accepts arguments of type UserRole or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRoleRelatedByUserId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinUserRoleRelatedByUserId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRoleRelatedByUserId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserRoleRelatedByUserId');
        }

        return $this;
    }

    /**
     * Use the UserRoleRelatedByUserId relation UserRole object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   UserRoleQuery A secondary query class using the current class as primary query
     */
    public function useUserRoleRelatedByUserIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserRoleRelatedByUserId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRoleRelatedByUserId', 'UserRoleQuery');
    }

    /**
     * Filter the query by a related Document object
     *
     * @param   Document|PropelObjectCollection $document  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDocumentRelatedByOwnerId($document, $comparison = null)
    {
        if ($document instanceof Document) {
            return $this
                ->addUsingAlias(UserPeer::ID, $document->getOwnerId(), $comparison);
        } elseif ($document instanceof PropelObjectCollection) {
            return $this
                ->useDocumentRelatedByOwnerIdQuery()
                ->filterByPrimaryKeys($document->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDocumentRelatedByOwnerId() only accepts arguments of type Document or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DocumentRelatedByOwnerId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinDocumentRelatedByOwnerId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DocumentRelatedByOwnerId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'DocumentRelatedByOwnerId');
        }

        return $this;
    }

    /**
     * Use the DocumentRelatedByOwnerId relation Document object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   DocumentQuery A secondary query class using the current class as primary query
     */
    public function useDocumentRelatedByOwnerIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDocumentRelatedByOwnerId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DocumentRelatedByOwnerId', 'DocumentQuery');
    }

    /**
     * Filter the query by a related Link object
     *
     * @param   Link|PropelObjectCollection $link  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLinkRelatedByOwnerId($link, $comparison = null)
    {
        if ($link instanceof Link) {
            return $this
                ->addUsingAlias(UserPeer::ID, $link->getOwnerId(), $comparison);
        } elseif ($link instanceof PropelObjectCollection) {
            return $this
                ->useLinkRelatedByOwnerIdQuery()
                ->filterByPrimaryKeys($link->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLinkRelatedByOwnerId() only accepts arguments of type Link or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LinkRelatedByOwnerId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinLinkRelatedByOwnerId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LinkRelatedByOwnerId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'LinkRelatedByOwnerId');
        }

        return $this;
    }

    /**
     * Use the LinkRelatedByOwnerId relation Link object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   LinkQuery A secondary query class using the current class as primary query
     */
    public function useLinkRelatedByOwnerIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinLinkRelatedByOwnerId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LinkRelatedByOwnerId', 'LinkQuery');
    }

    /**
     * Filter the query by a related Page object
     *
     * @param   Page|PropelObjectCollection $page  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPageRelatedByCreatedBy($page, $comparison = null)
    {
        if ($page instanceof Page) {
            return $this
                ->addUsingAlias(UserPeer::ID, $page->getCreatedBy(), $comparison);
        } elseif ($page instanceof PropelObjectCollection) {
            return $this
                ->usePageRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($page->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPageRelatedByCreatedBy() only accepts arguments of type Page or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PageRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinPageRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PageRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PageRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the PageRelatedByCreatedBy relation Page object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   PageQuery A secondary query class using the current class as primary query
     */
    public function usePageRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPageRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageRelatedByCreatedBy', 'PageQuery');
    }

    /**
     * Filter the query by a related Page object
     *
     * @param   Page|PropelObjectCollection $page  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPageRelatedByUpdatedBy($page, $comparison = null)
    {
        if ($page instanceof Page) {
            return $this
                ->addUsingAlias(UserPeer::ID, $page->getUpdatedBy(), $comparison);
        } elseif ($page instanceof PropelObjectCollection) {
            return $this
                ->usePageRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($page->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPageRelatedByUpdatedBy() only accepts arguments of type Page or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PageRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinPageRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PageRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PageRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the PageRelatedByUpdatedBy relation Page object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   PageQuery A secondary query class using the current class as primary query
     */
    public function usePageRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPageRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageRelatedByUpdatedBy', 'PageQuery');
    }

    /**
     * Filter the query by a related PageProperty object
     *
     * @param   PageProperty|PropelObjectCollection $pageProperty  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPagePropertyRelatedByCreatedBy($pageProperty, $comparison = null)
    {
        if ($pageProperty instanceof PageProperty) {
            return $this
                ->addUsingAlias(UserPeer::ID, $pageProperty->getCreatedBy(), $comparison);
        } elseif ($pageProperty instanceof PropelObjectCollection) {
            return $this
                ->usePagePropertyRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($pageProperty->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPagePropertyRelatedByCreatedBy() only accepts arguments of type PageProperty or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PagePropertyRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinPagePropertyRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PagePropertyRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PagePropertyRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the PagePropertyRelatedByCreatedBy relation PageProperty object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   PagePropertyQuery A secondary query class using the current class as primary query
     */
    public function usePagePropertyRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPagePropertyRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PagePropertyRelatedByCreatedBy', 'PagePropertyQuery');
    }

    /**
     * Filter the query by a related PageProperty object
     *
     * @param   PageProperty|PropelObjectCollection $pageProperty  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPagePropertyRelatedByUpdatedBy($pageProperty, $comparison = null)
    {
        if ($pageProperty instanceof PageProperty) {
            return $this
                ->addUsingAlias(UserPeer::ID, $pageProperty->getUpdatedBy(), $comparison);
        } elseif ($pageProperty instanceof PropelObjectCollection) {
            return $this
                ->usePagePropertyRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($pageProperty->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPagePropertyRelatedByUpdatedBy() only accepts arguments of type PageProperty or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PagePropertyRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinPagePropertyRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PagePropertyRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PagePropertyRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the PagePropertyRelatedByUpdatedBy relation PageProperty object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   PagePropertyQuery A secondary query class using the current class as primary query
     */
    public function usePagePropertyRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPagePropertyRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PagePropertyRelatedByUpdatedBy', 'PagePropertyQuery');
    }

    /**
     * Filter the query by a related PageString object
     *
     * @param   PageString|PropelObjectCollection $pageString  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPageStringRelatedByCreatedBy($pageString, $comparison = null)
    {
        if ($pageString instanceof PageString) {
            return $this
                ->addUsingAlias(UserPeer::ID, $pageString->getCreatedBy(), $comparison);
        } elseif ($pageString instanceof PropelObjectCollection) {
            return $this
                ->usePageStringRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($pageString->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPageStringRelatedByCreatedBy() only accepts arguments of type PageString or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PageStringRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinPageStringRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PageStringRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PageStringRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the PageStringRelatedByCreatedBy relation PageString object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   PageStringQuery A secondary query class using the current class as primary query
     */
    public function usePageStringRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPageStringRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageStringRelatedByCreatedBy', 'PageStringQuery');
    }

    /**
     * Filter the query by a related PageString object
     *
     * @param   PageString|PropelObjectCollection $pageString  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPageStringRelatedByUpdatedBy($pageString, $comparison = null)
    {
        if ($pageString instanceof PageString) {
            return $this
                ->addUsingAlias(UserPeer::ID, $pageString->getUpdatedBy(), $comparison);
        } elseif ($pageString instanceof PropelObjectCollection) {
            return $this
                ->usePageStringRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($pageString->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPageStringRelatedByUpdatedBy() only accepts arguments of type PageString or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PageStringRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinPageStringRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PageStringRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PageStringRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the PageStringRelatedByUpdatedBy relation PageString object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   PageStringQuery A secondary query class using the current class as primary query
     */
    public function usePageStringRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPageStringRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PageStringRelatedByUpdatedBy', 'PageStringQuery');
    }

    /**
     * Filter the query by a related ContentObject object
     *
     * @param   ContentObject|PropelObjectCollection $contentObject  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContentObjectRelatedByCreatedBy($contentObject, $comparison = null)
    {
        if ($contentObject instanceof ContentObject) {
            return $this
                ->addUsingAlias(UserPeer::ID, $contentObject->getCreatedBy(), $comparison);
        } elseif ($contentObject instanceof PropelObjectCollection) {
            return $this
                ->useContentObjectRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($contentObject->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContentObjectRelatedByCreatedBy() only accepts arguments of type ContentObject or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContentObjectRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinContentObjectRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContentObjectRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ContentObjectRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the ContentObjectRelatedByCreatedBy relation ContentObject object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   ContentObjectQuery A secondary query class using the current class as primary query
     */
    public function useContentObjectRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinContentObjectRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentObjectRelatedByCreatedBy', 'ContentObjectQuery');
    }

    /**
     * Filter the query by a related ContentObject object
     *
     * @param   ContentObject|PropelObjectCollection $contentObject  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContentObjectRelatedByUpdatedBy($contentObject, $comparison = null)
    {
        if ($contentObject instanceof ContentObject) {
            return $this
                ->addUsingAlias(UserPeer::ID, $contentObject->getUpdatedBy(), $comparison);
        } elseif ($contentObject instanceof PropelObjectCollection) {
            return $this
                ->useContentObjectRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($contentObject->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContentObjectRelatedByUpdatedBy() only accepts arguments of type ContentObject or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContentObjectRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinContentObjectRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContentObjectRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ContentObjectRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the ContentObjectRelatedByUpdatedBy relation ContentObject object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   ContentObjectQuery A secondary query class using the current class as primary query
     */
    public function useContentObjectRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinContentObjectRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContentObjectRelatedByUpdatedBy', 'ContentObjectQuery');
    }

    /**
     * Filter the query by a related LanguageObject object
     *
     * @param   LanguageObject|PropelObjectCollection $languageObject  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLanguageObjectRelatedByCreatedBy($languageObject, $comparison = null)
    {
        if ($languageObject instanceof LanguageObject) {
            return $this
                ->addUsingAlias(UserPeer::ID, $languageObject->getCreatedBy(), $comparison);
        } elseif ($languageObject instanceof PropelObjectCollection) {
            return $this
                ->useLanguageObjectRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($languageObject->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLanguageObjectRelatedByCreatedBy() only accepts arguments of type LanguageObject or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LanguageObjectRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinLanguageObjectRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LanguageObjectRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'LanguageObjectRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the LanguageObjectRelatedByCreatedBy relation LanguageObject object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   LanguageObjectQuery A secondary query class using the current class as primary query
     */
    public function useLanguageObjectRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLanguageObjectRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LanguageObjectRelatedByCreatedBy', 'LanguageObjectQuery');
    }

    /**
     * Filter the query by a related LanguageObject object
     *
     * @param   LanguageObject|PropelObjectCollection $languageObject  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLanguageObjectRelatedByUpdatedBy($languageObject, $comparison = null)
    {
        if ($languageObject instanceof LanguageObject) {
            return $this
                ->addUsingAlias(UserPeer::ID, $languageObject->getUpdatedBy(), $comparison);
        } elseif ($languageObject instanceof PropelObjectCollection) {
            return $this
                ->useLanguageObjectRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($languageObject->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLanguageObjectRelatedByUpdatedBy() only accepts arguments of type LanguageObject or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LanguageObjectRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinLanguageObjectRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LanguageObjectRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'LanguageObjectRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the LanguageObjectRelatedByUpdatedBy relation LanguageObject object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   LanguageObjectQuery A secondary query class using the current class as primary query
     */
    public function useLanguageObjectRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLanguageObjectRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LanguageObjectRelatedByUpdatedBy', 'LanguageObjectQuery');
    }

    /**
     * Filter the query by a related LanguageObjectHistory object
     *
     * @param   LanguageObjectHistory|PropelObjectCollection $languageObjectHistory  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLanguageObjectHistoryRelatedByCreatedBy($languageObjectHistory, $comparison = null)
    {
        if ($languageObjectHistory instanceof LanguageObjectHistory) {
            return $this
                ->addUsingAlias(UserPeer::ID, $languageObjectHistory->getCreatedBy(), $comparison);
        } elseif ($languageObjectHistory instanceof PropelObjectCollection) {
            return $this
                ->useLanguageObjectHistoryRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($languageObjectHistory->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLanguageObjectHistoryRelatedByCreatedBy() only accepts arguments of type LanguageObjectHistory or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LanguageObjectHistoryRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinLanguageObjectHistoryRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LanguageObjectHistoryRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'LanguageObjectHistoryRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the LanguageObjectHistoryRelatedByCreatedBy relation LanguageObjectHistory object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   LanguageObjectHistoryQuery A secondary query class using the current class as primary query
     */
    public function useLanguageObjectHistoryRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLanguageObjectHistoryRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LanguageObjectHistoryRelatedByCreatedBy', 'LanguageObjectHistoryQuery');
    }

    /**
     * Filter the query by a related LanguageObjectHistory object
     *
     * @param   LanguageObjectHistory|PropelObjectCollection $languageObjectHistory  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLanguageObjectHistoryRelatedByUpdatedBy($languageObjectHistory, $comparison = null)
    {
        if ($languageObjectHistory instanceof LanguageObjectHistory) {
            return $this
                ->addUsingAlias(UserPeer::ID, $languageObjectHistory->getUpdatedBy(), $comparison);
        } elseif ($languageObjectHistory instanceof PropelObjectCollection) {
            return $this
                ->useLanguageObjectHistoryRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($languageObjectHistory->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLanguageObjectHistoryRelatedByUpdatedBy() only accepts arguments of type LanguageObjectHistory or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LanguageObjectHistoryRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinLanguageObjectHistoryRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LanguageObjectHistoryRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'LanguageObjectHistoryRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the LanguageObjectHistoryRelatedByUpdatedBy relation LanguageObjectHistory object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   LanguageObjectHistoryQuery A secondary query class using the current class as primary query
     */
    public function useLanguageObjectHistoryRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLanguageObjectHistoryRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LanguageObjectHistoryRelatedByUpdatedBy', 'LanguageObjectHistoryQuery');
    }

    /**
     * Filter the query by a related Language object
     *
     * @param   Language|PropelObjectCollection $language  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLanguageRelatedByCreatedBy($language, $comparison = null)
    {
        if ($language instanceof Language) {
            return $this
                ->addUsingAlias(UserPeer::ID, $language->getCreatedBy(), $comparison);
        } elseif ($language instanceof PropelObjectCollection) {
            return $this
                ->useLanguageRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($language->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLanguageRelatedByCreatedBy() only accepts arguments of type Language or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LanguageRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinLanguageRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LanguageRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'LanguageRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the LanguageRelatedByCreatedBy relation Language object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   LanguageQuery A secondary query class using the current class as primary query
     */
    public function useLanguageRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLanguageRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LanguageRelatedByCreatedBy', 'LanguageQuery');
    }

    /**
     * Filter the query by a related Language object
     *
     * @param   Language|PropelObjectCollection $language  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLanguageRelatedByUpdatedBy($language, $comparison = null)
    {
        if ($language instanceof Language) {
            return $this
                ->addUsingAlias(UserPeer::ID, $language->getUpdatedBy(), $comparison);
        } elseif ($language instanceof PropelObjectCollection) {
            return $this
                ->useLanguageRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($language->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLanguageRelatedByUpdatedBy() only accepts arguments of type Language or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LanguageRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinLanguageRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LanguageRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'LanguageRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the LanguageRelatedByUpdatedBy relation Language object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   LanguageQuery A secondary query class using the current class as primary query
     */
    public function useLanguageRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLanguageRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LanguageRelatedByUpdatedBy', 'LanguageQuery');
    }

    /**
     * Filter the query by a related String object
     *
     * @param   String|PropelObjectCollection $string  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStringRelatedByCreatedBy($string, $comparison = null)
    {
        if ($string instanceof String) {
            return $this
                ->addUsingAlias(UserPeer::ID, $string->getCreatedBy(), $comparison);
        } elseif ($string instanceof PropelObjectCollection) {
            return $this
                ->useStringRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($string->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStringRelatedByCreatedBy() only accepts arguments of type String or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StringRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinStringRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StringRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'StringRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the StringRelatedByCreatedBy relation String object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   StringQuery A secondary query class using the current class as primary query
     */
    public function useStringRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStringRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StringRelatedByCreatedBy', 'StringQuery');
    }

    /**
     * Filter the query by a related String object
     *
     * @param   String|PropelObjectCollection $string  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStringRelatedByUpdatedBy($string, $comparison = null)
    {
        if ($string instanceof String) {
            return $this
                ->addUsingAlias(UserPeer::ID, $string->getUpdatedBy(), $comparison);
        } elseif ($string instanceof PropelObjectCollection) {
            return $this
                ->useStringRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($string->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStringRelatedByUpdatedBy() only accepts arguments of type String or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StringRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinStringRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StringRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'StringRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the StringRelatedByUpdatedBy relation String object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   StringQuery A secondary query class using the current class as primary query
     */
    public function useStringRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStringRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StringRelatedByUpdatedBy', 'StringQuery');
    }

    /**
     * Filter the query by a related UserGroup object
     *
     * @param   UserGroup|PropelObjectCollection $userGroup  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserGroupRelatedByCreatedBy($userGroup, $comparison = null)
    {
        if ($userGroup instanceof UserGroup) {
            return $this
                ->addUsingAlias(UserPeer::ID, $userGroup->getCreatedBy(), $comparison);
        } elseif ($userGroup instanceof PropelObjectCollection) {
            return $this
                ->useUserGroupRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($userGroup->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserGroupRelatedByCreatedBy() only accepts arguments of type UserGroup or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserGroupRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinUserGroupRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserGroupRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserGroupRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the UserGroupRelatedByCreatedBy relation UserGroup object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   UserGroupQuery A secondary query class using the current class as primary query
     */
    public function useUserGroupRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUserGroupRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserGroupRelatedByCreatedBy', 'UserGroupQuery');
    }

    /**
     * Filter the query by a related UserGroup object
     *
     * @param   UserGroup|PropelObjectCollection $userGroup  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserGroupRelatedByUpdatedBy($userGroup, $comparison = null)
    {
        if ($userGroup instanceof UserGroup) {
            return $this
                ->addUsingAlias(UserPeer::ID, $userGroup->getUpdatedBy(), $comparison);
        } elseif ($userGroup instanceof PropelObjectCollection) {
            return $this
                ->useUserGroupRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($userGroup->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserGroupRelatedByUpdatedBy() only accepts arguments of type UserGroup or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserGroupRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinUserGroupRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserGroupRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserGroupRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the UserGroupRelatedByUpdatedBy relation UserGroup object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   UserGroupQuery A secondary query class using the current class as primary query
     */
    public function useUserGroupRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUserGroupRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserGroupRelatedByUpdatedBy', 'UserGroupQuery');
    }

    /**
     * Filter the query by a related Group object
     *
     * @param   Group|PropelObjectCollection $group  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByGroupRelatedByCreatedBy($group, $comparison = null)
    {
        if ($group instanceof Group) {
            return $this
                ->addUsingAlias(UserPeer::ID, $group->getCreatedBy(), $comparison);
        } elseif ($group instanceof PropelObjectCollection) {
            return $this
                ->useGroupRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($group->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGroupRelatedByCreatedBy() only accepts arguments of type Group or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinGroupRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'GroupRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the GroupRelatedByCreatedBy relation Group object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   GroupQuery A secondary query class using the current class as primary query
     */
    public function useGroupRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGroupRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupRelatedByCreatedBy', 'GroupQuery');
    }

    /**
     * Filter the query by a related Group object
     *
     * @param   Group|PropelObjectCollection $group  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByGroupRelatedByUpdatedBy($group, $comparison = null)
    {
        if ($group instanceof Group) {
            return $this
                ->addUsingAlias(UserPeer::ID, $group->getUpdatedBy(), $comparison);
        } elseif ($group instanceof PropelObjectCollection) {
            return $this
                ->useGroupRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($group->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGroupRelatedByUpdatedBy() only accepts arguments of type Group or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinGroupRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'GroupRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the GroupRelatedByUpdatedBy relation Group object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   GroupQuery A secondary query class using the current class as primary query
     */
    public function useGroupRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGroupRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupRelatedByUpdatedBy', 'GroupQuery');
    }

    /**
     * Filter the query by a related GroupRole object
     *
     * @param   GroupRole|PropelObjectCollection $groupRole  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByGroupRoleRelatedByCreatedBy($groupRole, $comparison = null)
    {
        if ($groupRole instanceof GroupRole) {
            return $this
                ->addUsingAlias(UserPeer::ID, $groupRole->getCreatedBy(), $comparison);
        } elseif ($groupRole instanceof PropelObjectCollection) {
            return $this
                ->useGroupRoleRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($groupRole->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGroupRoleRelatedByCreatedBy() only accepts arguments of type GroupRole or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupRoleRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinGroupRoleRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupRoleRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'GroupRoleRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the GroupRoleRelatedByCreatedBy relation GroupRole object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   GroupRoleQuery A secondary query class using the current class as primary query
     */
    public function useGroupRoleRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGroupRoleRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupRoleRelatedByCreatedBy', 'GroupRoleQuery');
    }

    /**
     * Filter the query by a related GroupRole object
     *
     * @param   GroupRole|PropelObjectCollection $groupRole  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByGroupRoleRelatedByUpdatedBy($groupRole, $comparison = null)
    {
        if ($groupRole instanceof GroupRole) {
            return $this
                ->addUsingAlias(UserPeer::ID, $groupRole->getUpdatedBy(), $comparison);
        } elseif ($groupRole instanceof PropelObjectCollection) {
            return $this
                ->useGroupRoleRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($groupRole->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGroupRoleRelatedByUpdatedBy() only accepts arguments of type GroupRole or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupRoleRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinGroupRoleRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupRoleRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'GroupRoleRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the GroupRoleRelatedByUpdatedBy relation GroupRole object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   GroupRoleQuery A secondary query class using the current class as primary query
     */
    public function useGroupRoleRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinGroupRoleRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupRoleRelatedByUpdatedBy', 'GroupRoleQuery');
    }

    /**
     * Filter the query by a related Role object
     *
     * @param   Role|PropelObjectCollection $role  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRoleRelatedByCreatedBy($role, $comparison = null)
    {
        if ($role instanceof Role) {
            return $this
                ->addUsingAlias(UserPeer::ID, $role->getCreatedBy(), $comparison);
        } elseif ($role instanceof PropelObjectCollection) {
            return $this
                ->useRoleRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($role->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRoleRelatedByCreatedBy() only accepts arguments of type Role or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RoleRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinRoleRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RoleRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'RoleRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the RoleRelatedByCreatedBy relation Role object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   RoleQuery A secondary query class using the current class as primary query
     */
    public function useRoleRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRoleRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RoleRelatedByCreatedBy', 'RoleQuery');
    }

    /**
     * Filter the query by a related Role object
     *
     * @param   Role|PropelObjectCollection $role  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRoleRelatedByUpdatedBy($role, $comparison = null)
    {
        if ($role instanceof Role) {
            return $this
                ->addUsingAlias(UserPeer::ID, $role->getUpdatedBy(), $comparison);
        } elseif ($role instanceof PropelObjectCollection) {
            return $this
                ->useRoleRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($role->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRoleRelatedByUpdatedBy() only accepts arguments of type Role or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RoleRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinRoleRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RoleRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'RoleRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the RoleRelatedByUpdatedBy relation Role object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   RoleQuery A secondary query class using the current class as primary query
     */
    public function useRoleRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRoleRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RoleRelatedByUpdatedBy', 'RoleQuery');
    }

    /**
     * Filter the query by a related UserRole object
     *
     * @param   UserRole|PropelObjectCollection $userRole  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserRoleRelatedByCreatedBy($userRole, $comparison = null)
    {
        if ($userRole instanceof UserRole) {
            return $this
                ->addUsingAlias(UserPeer::ID, $userRole->getCreatedBy(), $comparison);
        } elseif ($userRole instanceof PropelObjectCollection) {
            return $this
                ->useUserRoleRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($userRole->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserRoleRelatedByCreatedBy() only accepts arguments of type UserRole or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRoleRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinUserRoleRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRoleRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserRoleRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the UserRoleRelatedByCreatedBy relation UserRole object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   UserRoleQuery A secondary query class using the current class as primary query
     */
    public function useUserRoleRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUserRoleRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRoleRelatedByCreatedBy', 'UserRoleQuery');
    }

    /**
     * Filter the query by a related UserRole object
     *
     * @param   UserRole|PropelObjectCollection $userRole  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserRoleRelatedByUpdatedBy($userRole, $comparison = null)
    {
        if ($userRole instanceof UserRole) {
            return $this
                ->addUsingAlias(UserPeer::ID, $userRole->getUpdatedBy(), $comparison);
        } elseif ($userRole instanceof PropelObjectCollection) {
            return $this
                ->useUserRoleRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($userRole->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserRoleRelatedByUpdatedBy() only accepts arguments of type UserRole or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserRoleRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinUserRoleRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserRoleRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserRoleRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the UserRoleRelatedByUpdatedBy relation UserRole object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   UserRoleQuery A secondary query class using the current class as primary query
     */
    public function useUserRoleRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUserRoleRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserRoleRelatedByUpdatedBy', 'UserRoleQuery');
    }

    /**
     * Filter the query by a related Right object
     *
     * @param   Right|PropelObjectCollection $right  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRightRelatedByCreatedBy($right, $comparison = null)
    {
        if ($right instanceof Right) {
            return $this
                ->addUsingAlias(UserPeer::ID, $right->getCreatedBy(), $comparison);
        } elseif ($right instanceof PropelObjectCollection) {
            return $this
                ->useRightRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($right->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRightRelatedByCreatedBy() only accepts arguments of type Right or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RightRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinRightRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RightRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'RightRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the RightRelatedByCreatedBy relation Right object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   RightQuery A secondary query class using the current class as primary query
     */
    public function useRightRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRightRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RightRelatedByCreatedBy', 'RightQuery');
    }

    /**
     * Filter the query by a related Right object
     *
     * @param   Right|PropelObjectCollection $right  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRightRelatedByUpdatedBy($right, $comparison = null)
    {
        if ($right instanceof Right) {
            return $this
                ->addUsingAlias(UserPeer::ID, $right->getUpdatedBy(), $comparison);
        } elseif ($right instanceof PropelObjectCollection) {
            return $this
                ->useRightRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($right->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRightRelatedByUpdatedBy() only accepts arguments of type Right or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RightRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinRightRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RightRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'RightRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the RightRelatedByUpdatedBy relation Right object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   RightQuery A secondary query class using the current class as primary query
     */
    public function useRightRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRightRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RightRelatedByUpdatedBy', 'RightQuery');
    }

    /**
     * Filter the query by a related Document object
     *
     * @param   Document|PropelObjectCollection $document  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDocumentRelatedByCreatedBy($document, $comparison = null)
    {
        if ($document instanceof Document) {
            return $this
                ->addUsingAlias(UserPeer::ID, $document->getCreatedBy(), $comparison);
        } elseif ($document instanceof PropelObjectCollection) {
            return $this
                ->useDocumentRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($document->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDocumentRelatedByCreatedBy() only accepts arguments of type Document or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DocumentRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinDocumentRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DocumentRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'DocumentRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the DocumentRelatedByCreatedBy relation Document object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   DocumentQuery A secondary query class using the current class as primary query
     */
    public function useDocumentRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDocumentRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DocumentRelatedByCreatedBy', 'DocumentQuery');
    }

    /**
     * Filter the query by a related Document object
     *
     * @param   Document|PropelObjectCollection $document  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDocumentRelatedByUpdatedBy($document, $comparison = null)
    {
        if ($document instanceof Document) {
            return $this
                ->addUsingAlias(UserPeer::ID, $document->getUpdatedBy(), $comparison);
        } elseif ($document instanceof PropelObjectCollection) {
            return $this
                ->useDocumentRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($document->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDocumentRelatedByUpdatedBy() only accepts arguments of type Document or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DocumentRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinDocumentRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DocumentRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'DocumentRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the DocumentRelatedByUpdatedBy relation Document object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   DocumentQuery A secondary query class using the current class as primary query
     */
    public function useDocumentRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDocumentRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DocumentRelatedByUpdatedBy', 'DocumentQuery');
    }

    /**
     * Filter the query by a related DocumentType object
     *
     * @param   DocumentType|PropelObjectCollection $documentType  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDocumentTypeRelatedByCreatedBy($documentType, $comparison = null)
    {
        if ($documentType instanceof DocumentType) {
            return $this
                ->addUsingAlias(UserPeer::ID, $documentType->getCreatedBy(), $comparison);
        } elseif ($documentType instanceof PropelObjectCollection) {
            return $this
                ->useDocumentTypeRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($documentType->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDocumentTypeRelatedByCreatedBy() only accepts arguments of type DocumentType or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DocumentTypeRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinDocumentTypeRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DocumentTypeRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'DocumentTypeRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the DocumentTypeRelatedByCreatedBy relation DocumentType object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   DocumentTypeQuery A secondary query class using the current class as primary query
     */
    public function useDocumentTypeRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDocumentTypeRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DocumentTypeRelatedByCreatedBy', 'DocumentTypeQuery');
    }

    /**
     * Filter the query by a related DocumentType object
     *
     * @param   DocumentType|PropelObjectCollection $documentType  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDocumentTypeRelatedByUpdatedBy($documentType, $comparison = null)
    {
        if ($documentType instanceof DocumentType) {
            return $this
                ->addUsingAlias(UserPeer::ID, $documentType->getUpdatedBy(), $comparison);
        } elseif ($documentType instanceof PropelObjectCollection) {
            return $this
                ->useDocumentTypeRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($documentType->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDocumentTypeRelatedByUpdatedBy() only accepts arguments of type DocumentType or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DocumentTypeRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinDocumentTypeRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DocumentTypeRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'DocumentTypeRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the DocumentTypeRelatedByUpdatedBy relation DocumentType object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   DocumentTypeQuery A secondary query class using the current class as primary query
     */
    public function useDocumentTypeRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDocumentTypeRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DocumentTypeRelatedByUpdatedBy', 'DocumentTypeQuery');
    }

    /**
     * Filter the query by a related DocumentCategory object
     *
     * @param   DocumentCategory|PropelObjectCollection $documentCategory  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDocumentCategoryRelatedByCreatedBy($documentCategory, $comparison = null)
    {
        if ($documentCategory instanceof DocumentCategory) {
            return $this
                ->addUsingAlias(UserPeer::ID, $documentCategory->getCreatedBy(), $comparison);
        } elseif ($documentCategory instanceof PropelObjectCollection) {
            return $this
                ->useDocumentCategoryRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($documentCategory->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDocumentCategoryRelatedByCreatedBy() only accepts arguments of type DocumentCategory or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DocumentCategoryRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinDocumentCategoryRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DocumentCategoryRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'DocumentCategoryRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the DocumentCategoryRelatedByCreatedBy relation DocumentCategory object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   DocumentCategoryQuery A secondary query class using the current class as primary query
     */
    public function useDocumentCategoryRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDocumentCategoryRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DocumentCategoryRelatedByCreatedBy', 'DocumentCategoryQuery');
    }

    /**
     * Filter the query by a related DocumentCategory object
     *
     * @param   DocumentCategory|PropelObjectCollection $documentCategory  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDocumentCategoryRelatedByUpdatedBy($documentCategory, $comparison = null)
    {
        if ($documentCategory instanceof DocumentCategory) {
            return $this
                ->addUsingAlias(UserPeer::ID, $documentCategory->getUpdatedBy(), $comparison);
        } elseif ($documentCategory instanceof PropelObjectCollection) {
            return $this
                ->useDocumentCategoryRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($documentCategory->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDocumentCategoryRelatedByUpdatedBy() only accepts arguments of type DocumentCategory or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DocumentCategoryRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinDocumentCategoryRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DocumentCategoryRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'DocumentCategoryRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the DocumentCategoryRelatedByUpdatedBy relation DocumentCategory object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   DocumentCategoryQuery A secondary query class using the current class as primary query
     */
    public function useDocumentCategoryRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDocumentCategoryRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DocumentCategoryRelatedByUpdatedBy', 'DocumentCategoryQuery');
    }

    /**
     * Filter the query by a related Tag object
     *
     * @param   Tag|PropelObjectCollection $tag  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTagRelatedByCreatedBy($tag, $comparison = null)
    {
        if ($tag instanceof Tag) {
            return $this
                ->addUsingAlias(UserPeer::ID, $tag->getCreatedBy(), $comparison);
        } elseif ($tag instanceof PropelObjectCollection) {
            return $this
                ->useTagRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($tag->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTagRelatedByCreatedBy() only accepts arguments of type Tag or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TagRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinTagRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TagRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'TagRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the TagRelatedByCreatedBy relation Tag object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   TagQuery A secondary query class using the current class as primary query
     */
    public function useTagRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTagRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TagRelatedByCreatedBy', 'TagQuery');
    }

    /**
     * Filter the query by a related Tag object
     *
     * @param   Tag|PropelObjectCollection $tag  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTagRelatedByUpdatedBy($tag, $comparison = null)
    {
        if ($tag instanceof Tag) {
            return $this
                ->addUsingAlias(UserPeer::ID, $tag->getUpdatedBy(), $comparison);
        } elseif ($tag instanceof PropelObjectCollection) {
            return $this
                ->useTagRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($tag->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTagRelatedByUpdatedBy() only accepts arguments of type Tag or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TagRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinTagRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TagRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'TagRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the TagRelatedByUpdatedBy relation Tag object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   TagQuery A secondary query class using the current class as primary query
     */
    public function useTagRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTagRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TagRelatedByUpdatedBy', 'TagQuery');
    }

    /**
     * Filter the query by a related TagInstance object
     *
     * @param   TagInstance|PropelObjectCollection $tagInstance  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTagInstanceRelatedByCreatedBy($tagInstance, $comparison = null)
    {
        if ($tagInstance instanceof TagInstance) {
            return $this
                ->addUsingAlias(UserPeer::ID, $tagInstance->getCreatedBy(), $comparison);
        } elseif ($tagInstance instanceof PropelObjectCollection) {
            return $this
                ->useTagInstanceRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($tagInstance->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTagInstanceRelatedByCreatedBy() only accepts arguments of type TagInstance or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TagInstanceRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinTagInstanceRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TagInstanceRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'TagInstanceRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the TagInstanceRelatedByCreatedBy relation TagInstance object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   TagInstanceQuery A secondary query class using the current class as primary query
     */
    public function useTagInstanceRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTagInstanceRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TagInstanceRelatedByCreatedBy', 'TagInstanceQuery');
    }

    /**
     * Filter the query by a related TagInstance object
     *
     * @param   TagInstance|PropelObjectCollection $tagInstance  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTagInstanceRelatedByUpdatedBy($tagInstance, $comparison = null)
    {
        if ($tagInstance instanceof TagInstance) {
            return $this
                ->addUsingAlias(UserPeer::ID, $tagInstance->getUpdatedBy(), $comparison);
        } elseif ($tagInstance instanceof PropelObjectCollection) {
            return $this
                ->useTagInstanceRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($tagInstance->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTagInstanceRelatedByUpdatedBy() only accepts arguments of type TagInstance or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TagInstanceRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinTagInstanceRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TagInstanceRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'TagInstanceRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the TagInstanceRelatedByUpdatedBy relation TagInstance object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   TagInstanceQuery A secondary query class using the current class as primary query
     */
    public function useTagInstanceRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTagInstanceRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TagInstanceRelatedByUpdatedBy', 'TagInstanceQuery');
    }

    /**
     * Filter the query by a related Link object
     *
     * @param   Link|PropelObjectCollection $link  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLinkRelatedByCreatedBy($link, $comparison = null)
    {
        if ($link instanceof Link) {
            return $this
                ->addUsingAlias(UserPeer::ID, $link->getCreatedBy(), $comparison);
        } elseif ($link instanceof PropelObjectCollection) {
            return $this
                ->useLinkRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($link->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLinkRelatedByCreatedBy() only accepts arguments of type Link or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LinkRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinLinkRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LinkRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'LinkRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the LinkRelatedByCreatedBy relation Link object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   LinkQuery A secondary query class using the current class as primary query
     */
    public function useLinkRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLinkRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LinkRelatedByCreatedBy', 'LinkQuery');
    }

    /**
     * Filter the query by a related Link object
     *
     * @param   Link|PropelObjectCollection $link  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLinkRelatedByUpdatedBy($link, $comparison = null)
    {
        if ($link instanceof Link) {
            return $this
                ->addUsingAlias(UserPeer::ID, $link->getUpdatedBy(), $comparison);
        } elseif ($link instanceof PropelObjectCollection) {
            return $this
                ->useLinkRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($link->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLinkRelatedByUpdatedBy() only accepts arguments of type Link or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LinkRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinLinkRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LinkRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'LinkRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the LinkRelatedByUpdatedBy relation Link object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   LinkQuery A secondary query class using the current class as primary query
     */
    public function useLinkRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLinkRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LinkRelatedByUpdatedBy', 'LinkQuery');
    }

    /**
     * Filter the query by a related LinkCategory object
     *
     * @param   LinkCategory|PropelObjectCollection $linkCategory  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLinkCategoryRelatedByCreatedBy($linkCategory, $comparison = null)
    {
        if ($linkCategory instanceof LinkCategory) {
            return $this
                ->addUsingAlias(UserPeer::ID, $linkCategory->getCreatedBy(), $comparison);
        } elseif ($linkCategory instanceof PropelObjectCollection) {
            return $this
                ->useLinkCategoryRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($linkCategory->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLinkCategoryRelatedByCreatedBy() only accepts arguments of type LinkCategory or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LinkCategoryRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinLinkCategoryRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LinkCategoryRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'LinkCategoryRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the LinkCategoryRelatedByCreatedBy relation LinkCategory object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   LinkCategoryQuery A secondary query class using the current class as primary query
     */
    public function useLinkCategoryRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLinkCategoryRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LinkCategoryRelatedByCreatedBy', 'LinkCategoryQuery');
    }

    /**
     * Filter the query by a related LinkCategory object
     *
     * @param   LinkCategory|PropelObjectCollection $linkCategory  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByLinkCategoryRelatedByUpdatedBy($linkCategory, $comparison = null)
    {
        if ($linkCategory instanceof LinkCategory) {
            return $this
                ->addUsingAlias(UserPeer::ID, $linkCategory->getUpdatedBy(), $comparison);
        } elseif ($linkCategory instanceof PropelObjectCollection) {
            return $this
                ->useLinkCategoryRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($linkCategory->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByLinkCategoryRelatedByUpdatedBy() only accepts arguments of type LinkCategory or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the LinkCategoryRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinLinkCategoryRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('LinkCategoryRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'LinkCategoryRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the LinkCategoryRelatedByUpdatedBy relation LinkCategory object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   LinkCategoryQuery A secondary query class using the current class as primary query
     */
    public function useLinkCategoryRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinLinkCategoryRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'LinkCategoryRelatedByUpdatedBy', 'LinkCategoryQuery');
    }

    /**
     * Filter the query by a related Reference object
     *
     * @param   Reference|PropelObjectCollection $reference  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByReferenceRelatedByCreatedBy($reference, $comparison = null)
    {
        if ($reference instanceof Reference) {
            return $this
                ->addUsingAlias(UserPeer::ID, $reference->getCreatedBy(), $comparison);
        } elseif ($reference instanceof PropelObjectCollection) {
            return $this
                ->useReferenceRelatedByCreatedByQuery()
                ->filterByPrimaryKeys($reference->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByReferenceRelatedByCreatedBy() only accepts arguments of type Reference or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ReferenceRelatedByCreatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinReferenceRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ReferenceRelatedByCreatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ReferenceRelatedByCreatedBy');
        }

        return $this;
    }

    /**
     * Use the ReferenceRelatedByCreatedBy relation Reference object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   ReferenceQuery A secondary query class using the current class as primary query
     */
    public function useReferenceRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinReferenceRelatedByCreatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ReferenceRelatedByCreatedBy', 'ReferenceQuery');
    }

    /**
     * Filter the query by a related Reference object
     *
     * @param   Reference|PropelObjectCollection $reference  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByReferenceRelatedByUpdatedBy($reference, $comparison = null)
    {
        if ($reference instanceof Reference) {
            return $this
                ->addUsingAlias(UserPeer::ID, $reference->getUpdatedBy(), $comparison);
        } elseif ($reference instanceof PropelObjectCollection) {
            return $this
                ->useReferenceRelatedByUpdatedByQuery()
                ->filterByPrimaryKeys($reference->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByReferenceRelatedByUpdatedBy() only accepts arguments of type Reference or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ReferenceRelatedByUpdatedBy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function joinReferenceRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ReferenceRelatedByUpdatedBy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ReferenceRelatedByUpdatedBy');
        }

        return $this;
    }

    /**
     * Use the ReferenceRelatedByUpdatedBy relation Reference object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   ReferenceQuery A secondary query class using the current class as primary query
     */
    public function useReferenceRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinReferenceRelatedByUpdatedBy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ReferenceRelatedByUpdatedBy', 'ReferenceQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   User $user Object to remove from the list of results
     *
     * @return UserQuery The current query, for fluid interface
     */
    public function prune($user = null)
    {
        if ($user) {
            $this->addUsingAlias(UserPeer::ID, $user->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // extended_timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     UserQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(UserPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     UserQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     UserQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     UserQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(UserPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     UserQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     UserQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserPeer::CREATED_AT);
    }
    // extended_keyable behavior

    public function filterByPKArray($pkArray) {
            return $this->filterByPrimaryKey($pkArray[0]);
    }

    public function filterByPKString($pkString) {
        return $this->filterByPrimaryKey($pkString);
    }

}
