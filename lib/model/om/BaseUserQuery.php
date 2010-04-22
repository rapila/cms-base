<?php


/**
 * Base class that represents a query for the 'users' table.
 *
 * 
 *
 * @method     UserQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     UserQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     UserQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     UserQuery orderByFirstName($order = Criteria::ASC) Order by the first_name column
 * @method     UserQuery orderByLastName($order = Criteria::ASC) Order by the last_name column
 * @method     UserQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     UserQuery orderByLanguageId($order = Criteria::ASC) Order by the language_id column
 * @method     UserQuery orderByIsAdmin($order = Criteria::ASC) Order by the is_admin column
 * @method     UserQuery orderByIsBackendLoginEnabled($order = Criteria::ASC) Order by the is_backend_login_enabled column
 * @method     UserQuery orderByIsInactive($order = Criteria::ASC) Order by the is_inactive column
 * @method     UserQuery orderByPasswordRecoverHint($order = Criteria::ASC) Order by the password_recover_hint column
 * @method     UserQuery orderByBackendSettings($order = Criteria::ASC) Order by the backend_settings column
 * @method     UserQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     UserQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     UserQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     UserQuery orderByUpdatedBy($order = Criteria::ASC) Order by the updated_by column
 *
 * @method     UserQuery groupById() Group by the id column
 * @method     UserQuery groupByUsername() Group by the username column
 * @method     UserQuery groupByPassword() Group by the password column
 * @method     UserQuery groupByFirstName() Group by the first_name column
 * @method     UserQuery groupByLastName() Group by the last_name column
 * @method     UserQuery groupByEmail() Group by the email column
 * @method     UserQuery groupByLanguageId() Group by the language_id column
 * @method     UserQuery groupByIsAdmin() Group by the is_admin column
 * @method     UserQuery groupByIsBackendLoginEnabled() Group by the is_backend_login_enabled column
 * @method     UserQuery groupByIsInactive() Group by the is_inactive column
 * @method     UserQuery groupByPasswordRecoverHint() Group by the password_recover_hint column
 * @method     UserQuery groupByBackendSettings() Group by the backend_settings column
 * @method     UserQuery groupByCreatedAt() Group by the created_at column
 * @method     UserQuery groupByUpdatedAt() Group by the updated_at column
 * @method     UserQuery groupByCreatedBy() Group by the created_by column
 * @method     UserQuery groupByUpdatedBy() Group by the updated_by column
 *
 * @method     UserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     UserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     UserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     UserQuery leftJoinLanguage($relationAlias = '') Adds a LEFT JOIN clause to the query using the Language relation
 * @method     UserQuery rightJoinLanguage($relationAlias = '') Adds a RIGHT JOIN clause to the query using the Language relation
 * @method     UserQuery innerJoinLanguage($relationAlias = '') Adds a INNER JOIN clause to the query using the Language relation
 *
 * @method     UserQuery leftJoinUserRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     UserQuery rightJoinUserRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     UserQuery innerJoinUserRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinPageRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the PageRelatedByCreatedBy relation
 * @method     UserQuery rightJoinPageRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the PageRelatedByCreatedBy relation
 * @method     UserQuery innerJoinPageRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the PageRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinPageRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the PageRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinPageRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the PageRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinPageRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the PageRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinPagePropertyRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the PagePropertyRelatedByCreatedBy relation
 * @method     UserQuery rightJoinPagePropertyRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the PagePropertyRelatedByCreatedBy relation
 * @method     UserQuery innerJoinPagePropertyRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the PagePropertyRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinPagePropertyRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the PagePropertyRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinPagePropertyRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the PagePropertyRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinPagePropertyRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the PagePropertyRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinPageStringRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the PageStringRelatedByCreatedBy relation
 * @method     UserQuery rightJoinPageStringRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the PageStringRelatedByCreatedBy relation
 * @method     UserQuery innerJoinPageStringRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the PageStringRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinPageStringRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the PageStringRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinPageStringRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the PageStringRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinPageStringRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the PageStringRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinContentObjectRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the ContentObjectRelatedByCreatedBy relation
 * @method     UserQuery rightJoinContentObjectRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the ContentObjectRelatedByCreatedBy relation
 * @method     UserQuery innerJoinContentObjectRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the ContentObjectRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinContentObjectRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the ContentObjectRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinContentObjectRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the ContentObjectRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinContentObjectRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the ContentObjectRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinLanguageObjectRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the LanguageObjectRelatedByCreatedBy relation
 * @method     UserQuery rightJoinLanguageObjectRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LanguageObjectRelatedByCreatedBy relation
 * @method     UserQuery innerJoinLanguageObjectRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the LanguageObjectRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinLanguageObjectRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the LanguageObjectRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinLanguageObjectRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LanguageObjectRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinLanguageObjectRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the LanguageObjectRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinLanguageObjectHistoryRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the LanguageObjectHistoryRelatedByCreatedBy relation
 * @method     UserQuery rightJoinLanguageObjectHistoryRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LanguageObjectHistoryRelatedByCreatedBy relation
 * @method     UserQuery innerJoinLanguageObjectHistoryRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the LanguageObjectHistoryRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinLanguageObjectHistoryRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the LanguageObjectHistoryRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinLanguageObjectHistoryRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LanguageObjectHistoryRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinLanguageObjectHistoryRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the LanguageObjectHistoryRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinLanguageRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the LanguageRelatedByCreatedBy relation
 * @method     UserQuery rightJoinLanguageRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LanguageRelatedByCreatedBy relation
 * @method     UserQuery innerJoinLanguageRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the LanguageRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinLanguageRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the LanguageRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinLanguageRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LanguageRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinLanguageRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the LanguageRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinStringRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the StringRelatedByCreatedBy relation
 * @method     UserQuery rightJoinStringRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the StringRelatedByCreatedBy relation
 * @method     UserQuery innerJoinStringRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the StringRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinStringRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the StringRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinStringRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the StringRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinStringRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the StringRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinUserRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     UserQuery rightJoinUserRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByCreatedBy relation
 * @method     UserQuery innerJoinUserRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinUserRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinGroupRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the GroupRelatedByCreatedBy relation
 * @method     UserQuery rightJoinGroupRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the GroupRelatedByCreatedBy relation
 * @method     UserQuery innerJoinGroupRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the GroupRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinGroupRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the GroupRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinGroupRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the GroupRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinGroupRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the GroupRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinUserGroupRelatedByUserId($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserGroupRelatedByUserId relation
 * @method     UserQuery rightJoinUserGroupRelatedByUserId($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserGroupRelatedByUserId relation
 * @method     UserQuery innerJoinUserGroupRelatedByUserId($relationAlias = '') Adds a INNER JOIN clause to the query using the UserGroupRelatedByUserId relation
 *
 * @method     UserQuery leftJoinUserGroupRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserGroupRelatedByCreatedBy relation
 * @method     UserQuery rightJoinUserGroupRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserGroupRelatedByCreatedBy relation
 * @method     UserQuery innerJoinUserGroupRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserGroupRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinUserGroupRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the UserGroupRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinUserGroupRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the UserGroupRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinUserGroupRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the UserGroupRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinRightRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the RightRelatedByCreatedBy relation
 * @method     UserQuery rightJoinRightRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the RightRelatedByCreatedBy relation
 * @method     UserQuery innerJoinRightRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the RightRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinRightRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the RightRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinRightRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the RightRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinRightRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the RightRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinDocumentRelatedByOwnerId($relationAlias = '') Adds a LEFT JOIN clause to the query using the DocumentRelatedByOwnerId relation
 * @method     UserQuery rightJoinDocumentRelatedByOwnerId($relationAlias = '') Adds a RIGHT JOIN clause to the query using the DocumentRelatedByOwnerId relation
 * @method     UserQuery innerJoinDocumentRelatedByOwnerId($relationAlias = '') Adds a INNER JOIN clause to the query using the DocumentRelatedByOwnerId relation
 *
 * @method     UserQuery leftJoinDocumentRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the DocumentRelatedByCreatedBy relation
 * @method     UserQuery rightJoinDocumentRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the DocumentRelatedByCreatedBy relation
 * @method     UserQuery innerJoinDocumentRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the DocumentRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinDocumentRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the DocumentRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinDocumentRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the DocumentRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinDocumentRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the DocumentRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinDocumentTypeRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the DocumentTypeRelatedByCreatedBy relation
 * @method     UserQuery rightJoinDocumentTypeRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the DocumentTypeRelatedByCreatedBy relation
 * @method     UserQuery innerJoinDocumentTypeRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the DocumentTypeRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinDocumentTypeRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the DocumentTypeRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinDocumentTypeRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the DocumentTypeRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinDocumentTypeRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the DocumentTypeRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinDocumentCategoryRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the DocumentCategoryRelatedByCreatedBy relation
 * @method     UserQuery rightJoinDocumentCategoryRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the DocumentCategoryRelatedByCreatedBy relation
 * @method     UserQuery innerJoinDocumentCategoryRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the DocumentCategoryRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinDocumentCategoryRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the DocumentCategoryRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinDocumentCategoryRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the DocumentCategoryRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinDocumentCategoryRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the DocumentCategoryRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinTagRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the TagRelatedByCreatedBy relation
 * @method     UserQuery rightJoinTagRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the TagRelatedByCreatedBy relation
 * @method     UserQuery innerJoinTagRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the TagRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinTagRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the TagRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinTagRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the TagRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinTagRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the TagRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinTagInstanceRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the TagInstanceRelatedByCreatedBy relation
 * @method     UserQuery rightJoinTagInstanceRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the TagInstanceRelatedByCreatedBy relation
 * @method     UserQuery innerJoinTagInstanceRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the TagInstanceRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinTagInstanceRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the TagInstanceRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinTagInstanceRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the TagInstanceRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinTagInstanceRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the TagInstanceRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinLinkRelatedByOwnerId($relationAlias = '') Adds a LEFT JOIN clause to the query using the LinkRelatedByOwnerId relation
 * @method     UserQuery rightJoinLinkRelatedByOwnerId($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LinkRelatedByOwnerId relation
 * @method     UserQuery innerJoinLinkRelatedByOwnerId($relationAlias = '') Adds a INNER JOIN clause to the query using the LinkRelatedByOwnerId relation
 *
 * @method     UserQuery leftJoinLinkRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the LinkRelatedByCreatedBy relation
 * @method     UserQuery rightJoinLinkRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LinkRelatedByCreatedBy relation
 * @method     UserQuery innerJoinLinkRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the LinkRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinLinkRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the LinkRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinLinkRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LinkRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinLinkRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the LinkRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinLinkCategoryRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the LinkCategoryRelatedByCreatedBy relation
 * @method     UserQuery rightJoinLinkCategoryRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LinkCategoryRelatedByCreatedBy relation
 * @method     UserQuery innerJoinLinkCategoryRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the LinkCategoryRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinLinkCategoryRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the LinkCategoryRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinLinkCategoryRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the LinkCategoryRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinLinkCategoryRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the LinkCategoryRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinReferenceRelatedByCreatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the ReferenceRelatedByCreatedBy relation
 * @method     UserQuery rightJoinReferenceRelatedByCreatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the ReferenceRelatedByCreatedBy relation
 * @method     UserQuery innerJoinReferenceRelatedByCreatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the ReferenceRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinReferenceRelatedByUpdatedBy($relationAlias = '') Adds a LEFT JOIN clause to the query using the ReferenceRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinReferenceRelatedByUpdatedBy($relationAlias = '') Adds a RIGHT JOIN clause to the query using the ReferenceRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinReferenceRelatedByUpdatedBy($relationAlias = '') Adds a INNER JOIN clause to the query using the ReferenceRelatedByUpdatedBy relation
 *
 * @method     User findOne(PropelPDO $con = null) Return the first User matching the query
 * @method     User findOneById(int $id) Return the first User filtered by the id column
 * @method     User findOneByUsername(string $username) Return the first User filtered by the username column
 * @method     User findOneByPassword(string $password) Return the first User filtered by the password column
 * @method     User findOneByFirstName(string $first_name) Return the first User filtered by the first_name column
 * @method     User findOneByLastName(string $last_name) Return the first User filtered by the last_name column
 * @method     User findOneByEmail(string $email) Return the first User filtered by the email column
 * @method     User findOneByLanguageId(string $language_id) Return the first User filtered by the language_id column
 * @method     User findOneByIsAdmin(boolean $is_admin) Return the first User filtered by the is_admin column
 * @method     User findOneByIsBackendLoginEnabled(boolean $is_backend_login_enabled) Return the first User filtered by the is_backend_login_enabled column
 * @method     User findOneByIsInactive(boolean $is_inactive) Return the first User filtered by the is_inactive column
 * @method     User findOneByPasswordRecoverHint(string $password_recover_hint) Return the first User filtered by the password_recover_hint column
 * @method     User findOneByBackendSettings(string $backend_settings) Return the first User filtered by the backend_settings column
 * @method     User findOneByCreatedAt(string $created_at) Return the first User filtered by the created_at column
 * @method     User findOneByUpdatedAt(string $updated_at) Return the first User filtered by the updated_at column
 * @method     User findOneByCreatedBy(int $created_by) Return the first User filtered by the created_by column
 * @method     User findOneByUpdatedBy(int $updated_by) Return the first User filtered by the updated_by column
 *
 * @method     array findById(int $id) Return User objects filtered by the id column
 * @method     array findByUsername(string $username) Return User objects filtered by the username column
 * @method     array findByPassword(string $password) Return User objects filtered by the password column
 * @method     array findByFirstName(string $first_name) Return User objects filtered by the first_name column
 * @method     array findByLastName(string $last_name) Return User objects filtered by the last_name column
 * @method     array findByEmail(string $email) Return User objects filtered by the email column
 * @method     array findByLanguageId(string $language_id) Return User objects filtered by the language_id column
 * @method     array findByIsAdmin(boolean $is_admin) Return User objects filtered by the is_admin column
 * @method     array findByIsBackendLoginEnabled(boolean $is_backend_login_enabled) Return User objects filtered by the is_backend_login_enabled column
 * @method     array findByIsInactive(boolean $is_inactive) Return User objects filtered by the is_inactive column
 * @method     array findByPasswordRecoverHint(string $password_recover_hint) Return User objects filtered by the password_recover_hint column
 * @method     array findByBackendSettings(string $backend_settings) Return User objects filtered by the backend_settings column
 * @method     array findByCreatedAt(string $created_at) Return User objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return User objects filtered by the updated_at column
 * @method     array findByCreatedBy(int $created_by) Return User objects filtered by the created_by column
 * @method     array findByUpdatedBy(int $updated_by) Return User objects filtered by the updated_by column
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
	public function __construct($dbName = 'mini_cms', $modelName = 'User', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new UserQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    UserQuery
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
	 * Find object by primary key
	 * Use instance pooling to avoid a database query if the object exists
	 * <code>
	 * $obj  = $c->findPk(12, $con);
	 * </code>
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    User|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = UserPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
			// the object is alredy in the instance pool
			return $obj;
		} else {
			// the object has not been requested yet, or the formatter is not an object formatter
			$stmt = $this
				->filterByPrimaryKey($key)
				->getSelectStatement($con);
			return $this->getFormatter()->formatOne($stmt);
		}
	}

	/**
	 * Find objects by primary key
	 * <code>
	 * $objs = $c->findPks(array(12, 56, 832), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
	 */
	public function findPks($keys, $con = null)
	{	
		return $this
			->filterByPrimaryKeys($keys)
			->find($con);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    UserQuery The current query, for fluid interface
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
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(UserPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 * 
	 * @param     int|array $id The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($id) && $comparison == Criteria::EQUAL) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(UserPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the username column
	 * 
	 * @param     string $username The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUsername($username = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($username)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $username)) {
			$username = str_replace('*', '%', $username);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::USERNAME, $username, $comparison);
	}

	/**
	 * Filter the query on the password column
	 * 
	 * @param     string $password The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPassword($password = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($password)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $password)) {
			$password = str_replace('*', '%', $password);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::PASSWORD, $password, $comparison);
	}

	/**
	 * Filter the query on the first_name column
	 * 
	 * @param     string $firstName The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByFirstName($firstName = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($firstName)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $firstName)) {
			$firstName = str_replace('*', '%', $firstName);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::FIRST_NAME, $firstName, $comparison);
	}

	/**
	 * Filter the query on the last_name column
	 * 
	 * @param     string $lastName The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLastName($lastName = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($lastName)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $lastName)) {
			$lastName = str_replace('*', '%', $lastName);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::LAST_NAME, $lastName, $comparison);
	}

	/**
	 * Filter the query on the email column
	 * 
	 * @param     string $email The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByEmail($email = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($email)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $email)) {
			$email = str_replace('*', '%', $email);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::EMAIL, $email, $comparison);
	}

	/**
	 * Filter the query on the language_id column
	 * 
	 * @param     string $languageId The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLanguageId($languageId = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($languageId)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $languageId)) {
			$languageId = str_replace('*', '%', $languageId);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::LANGUAGE_ID, $languageId, $comparison);
	}

	/**
	 * Filter the query on the is_admin column
	 * 
	 * @param     boolean|string $isAdmin The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByIsAdmin($isAdmin = null, $comparison = Criteria::EQUAL)
	{
		if (is_string($isAdmin)) {
			$is_admin = in_array(strtolower($isAdmin), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(UserPeer::IS_ADMIN, $isAdmin, $comparison);
	}

	/**
	 * Filter the query on the is_backend_login_enabled column
	 * 
	 * @param     boolean|string $isBackendLoginEnabled The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByIsBackendLoginEnabled($isBackendLoginEnabled = null, $comparison = Criteria::EQUAL)
	{
		if (is_string($isBackendLoginEnabled)) {
			$is_backend_login_enabled = in_array(strtolower($isBackendLoginEnabled), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(UserPeer::IS_BACKEND_LOGIN_ENABLED, $isBackendLoginEnabled, $comparison);
	}

	/**
	 * Filter the query on the is_inactive column
	 * 
	 * @param     boolean|string $isInactive The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByIsInactive($isInactive = null, $comparison = Criteria::EQUAL)
	{
		if (is_string($isInactive)) {
			$is_inactive = in_array(strtolower($isInactive), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(UserPeer::IS_INACTIVE, $isInactive, $comparison);
	}

	/**
	 * Filter the query on the password_recover_hint column
	 * 
	 * @param     string $passwordRecoverHint The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPasswordRecoverHint($passwordRecoverHint = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($passwordRecoverHint)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $passwordRecoverHint)) {
			$passwordRecoverHint = str_replace('*', '%', $passwordRecoverHint);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::PASSWORD_RECOVER_HINT, $passwordRecoverHint, $comparison);
	}

	/**
	 * Filter the query on the backend_settings column
	 * 
	 * @param     string $backendSettings The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByBackendSettings($backendSettings = null, $comparison = Criteria::EQUAL)
	{
		if (is_array($backendSettings)) {
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		} elseif (preg_match('/[\%\*]/', $backendSettings)) {
			$backendSettings = str_replace('*', '%', $backendSettings);
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::BACKEND_SETTINGS, $backendSettings, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 * 
	 * @param     string|array $createdAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = Criteria::EQUAL)
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
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(UserPeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 * 
	 * @param     string|array $updatedAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = Criteria::EQUAL)
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
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(UserPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query on the created_by column
	 * 
	 * @param     int|array $createdBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByCreatedBy($createdBy = null, $comparison = Criteria::EQUAL)
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
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(UserPeer::CREATED_BY, $createdBy, $comparison);
	}

	/**
	 * Filter the query on the updated_by column
	 * 
	 * @param     int|array $updatedBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUpdatedBy($updatedBy = null, $comparison = Criteria::EQUAL)
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
			if ($comparison == Criteria::EQUAL) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(UserPeer::UPDATED_BY, $updatedBy, $comparison);
	}

	/**
	 * Filter the query by a related Language object
	 *
	 * @param     Language $language  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLanguage($language, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::LANGUAGE_ID, $language->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Language relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinLanguage($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Language');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'Language');
		}
		
		return $this;
	}

	/**
	 * Use the Language relation Language object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LanguageQuery A secondary query class using the current class as primary query
	 */
	public function useLanguageQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinLanguage($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Language', 'LanguageQuery');
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByCreatedBy($user, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::CREATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinUserRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('UserRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'UserRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the UserRelatedByCreatedBy relation User object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery A secondary query class using the current class as primary query
	 */
	public function useUserRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinUserRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserRelatedByCreatedBy', 'UserQuery');
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByUpdatedBy($user, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::UPDATED_BY, $user->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinUserRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('UserRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'UserRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the UserRelatedByUpdatedBy relation User object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery A secondary query class using the current class as primary query
	 */
	public function useUserRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinUserRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserRelatedByUpdatedBy', 'UserQuery');
	}

	/**
	 * Filter the query by a related Page object
	 *
	 * @param     Page $page  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPageRelatedByCreatedBy($page, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $page->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the PageRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinPageRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PageRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    PageQuery A secondary query class using the current class as primary query
	 */
	public function usePageRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinPageRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'PageRelatedByCreatedBy', 'PageQuery');
	}

	/**
	 * Filter the query by a related Page object
	 *
	 * @param     Page $page  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPageRelatedByUpdatedBy($page, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $page->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the PageRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinPageRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PageRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    PageQuery A secondary query class using the current class as primary query
	 */
	public function usePageRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinPageRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'PageRelatedByUpdatedBy', 'PageQuery');
	}

	/**
	 * Filter the query by a related PageProperty object
	 *
	 * @param     PageProperty $pageProperty  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPagePropertyRelatedByCreatedBy($pageProperty, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $pageProperty->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the PagePropertyRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinPagePropertyRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PagePropertyRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    PagePropertyQuery A secondary query class using the current class as primary query
	 */
	public function usePagePropertyRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinPagePropertyRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'PagePropertyRelatedByCreatedBy', 'PagePropertyQuery');
	}

	/**
	 * Filter the query by a related PageProperty object
	 *
	 * @param     PageProperty $pageProperty  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPagePropertyRelatedByUpdatedBy($pageProperty, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $pageProperty->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the PagePropertyRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinPagePropertyRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PagePropertyRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    PagePropertyQuery A secondary query class using the current class as primary query
	 */
	public function usePagePropertyRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinPagePropertyRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'PagePropertyRelatedByUpdatedBy', 'PagePropertyQuery');
	}

	/**
	 * Filter the query by a related PageString object
	 *
	 * @param     PageString $pageString  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPageStringRelatedByCreatedBy($pageString, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $pageString->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the PageStringRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinPageStringRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PageStringRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    PageStringQuery A secondary query class using the current class as primary query
	 */
	public function usePageStringRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinPageStringRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'PageStringRelatedByCreatedBy', 'PageStringQuery');
	}

	/**
	 * Filter the query by a related PageString object
	 *
	 * @param     PageString $pageString  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPageStringRelatedByUpdatedBy($pageString, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $pageString->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the PageStringRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinPageStringRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('PageStringRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    PageStringQuery A secondary query class using the current class as primary query
	 */
	public function usePageStringRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinPageStringRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'PageStringRelatedByUpdatedBy', 'PageStringQuery');
	}

	/**
	 * Filter the query by a related ContentObject object
	 *
	 * @param     ContentObject $contentObject  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByContentObjectRelatedByCreatedBy($contentObject, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $contentObject->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the ContentObjectRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinContentObjectRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('ContentObjectRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    ContentObjectQuery A secondary query class using the current class as primary query
	 */
	public function useContentObjectRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinContentObjectRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'ContentObjectRelatedByCreatedBy', 'ContentObjectQuery');
	}

	/**
	 * Filter the query by a related ContentObject object
	 *
	 * @param     ContentObject $contentObject  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByContentObjectRelatedByUpdatedBy($contentObject, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $contentObject->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the ContentObjectRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinContentObjectRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('ContentObjectRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    ContentObjectQuery A secondary query class using the current class as primary query
	 */
	public function useContentObjectRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinContentObjectRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'ContentObjectRelatedByUpdatedBy', 'ContentObjectQuery');
	}

	/**
	 * Filter the query by a related LanguageObject object
	 *
	 * @param     LanguageObject $languageObject  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLanguageObjectRelatedByCreatedBy($languageObject, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $languageObject->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LanguageObjectRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinLanguageObjectRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('LanguageObjectRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    LanguageObjectQuery A secondary query class using the current class as primary query
	 */
	public function useLanguageObjectRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinLanguageObjectRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'LanguageObjectRelatedByCreatedBy', 'LanguageObjectQuery');
	}

	/**
	 * Filter the query by a related LanguageObject object
	 *
	 * @param     LanguageObject $languageObject  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLanguageObjectRelatedByUpdatedBy($languageObject, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $languageObject->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LanguageObjectRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinLanguageObjectRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('LanguageObjectRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    LanguageObjectQuery A secondary query class using the current class as primary query
	 */
	public function useLanguageObjectRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinLanguageObjectRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'LanguageObjectRelatedByUpdatedBy', 'LanguageObjectQuery');
	}

	/**
	 * Filter the query by a related LanguageObjectHistory object
	 *
	 * @param     LanguageObjectHistory $languageObjectHistory  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLanguageObjectHistoryRelatedByCreatedBy($languageObjectHistory, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $languageObjectHistory->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LanguageObjectHistoryRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinLanguageObjectHistoryRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('LanguageObjectHistoryRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    LanguageObjectHistoryQuery A secondary query class using the current class as primary query
	 */
	public function useLanguageObjectHistoryRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinLanguageObjectHistoryRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'LanguageObjectHistoryRelatedByCreatedBy', 'LanguageObjectHistoryQuery');
	}

	/**
	 * Filter the query by a related LanguageObjectHistory object
	 *
	 * @param     LanguageObjectHistory $languageObjectHistory  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLanguageObjectHistoryRelatedByUpdatedBy($languageObjectHistory, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $languageObjectHistory->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LanguageObjectHistoryRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinLanguageObjectHistoryRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('LanguageObjectHistoryRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    LanguageObjectHistoryQuery A secondary query class using the current class as primary query
	 */
	public function useLanguageObjectHistoryRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinLanguageObjectHistoryRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'LanguageObjectHistoryRelatedByUpdatedBy', 'LanguageObjectHistoryQuery');
	}

	/**
	 * Filter the query by a related Language object
	 *
	 * @param     Language $language  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLanguageRelatedByCreatedBy($language, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $language->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LanguageRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinLanguageRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('LanguageRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    LanguageQuery A secondary query class using the current class as primary query
	 */
	public function useLanguageRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinLanguageRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'LanguageRelatedByCreatedBy', 'LanguageQuery');
	}

	/**
	 * Filter the query by a related Language object
	 *
	 * @param     Language $language  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLanguageRelatedByUpdatedBy($language, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $language->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LanguageRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinLanguageRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('LanguageRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    LanguageQuery A secondary query class using the current class as primary query
	 */
	public function useLanguageRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinLanguageRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'LanguageRelatedByUpdatedBy', 'LanguageQuery');
	}

	/**
	 * Filter the query by a related String object
	 *
	 * @param     String $string  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByStringRelatedByCreatedBy($string, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $string->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the StringRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinStringRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('StringRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    StringQuery A secondary query class using the current class as primary query
	 */
	public function useStringRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinStringRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'StringRelatedByCreatedBy', 'StringQuery');
	}

	/**
	 * Filter the query by a related String object
	 *
	 * @param     String $string  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByStringRelatedByUpdatedBy($string, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $string->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the StringRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinStringRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('StringRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    StringQuery A secondary query class using the current class as primary query
	 */
	public function useStringRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinStringRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'StringRelatedByUpdatedBy', 'StringQuery');
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByCreatedBy($user, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $user->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinUserRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('UserRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'UserRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the UserRelatedByCreatedBy relation User object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery A secondary query class using the current class as primary query
	 */
	public function useUserRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinUserRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserRelatedByCreatedBy', 'UserQuery');
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUserRelatedByUpdatedBy($user, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $user->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinUserRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('UserRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'UserRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the UserRelatedByUpdatedBy relation User object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery A secondary query class using the current class as primary query
	 */
	public function useUserRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinUserRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserRelatedByUpdatedBy', 'UserQuery');
	}

	/**
	 * Filter the query by a related Group object
	 *
	 * @param     Group $group  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByGroupRelatedByCreatedBy($group, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $group->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the GroupRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinGroupRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('GroupRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    GroupQuery A secondary query class using the current class as primary query
	 */
	public function useGroupRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinGroupRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'GroupRelatedByCreatedBy', 'GroupQuery');
	}

	/**
	 * Filter the query by a related Group object
	 *
	 * @param     Group $group  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByGroupRelatedByUpdatedBy($group, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $group->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the GroupRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinGroupRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('GroupRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    GroupQuery A secondary query class using the current class as primary query
	 */
	public function useGroupRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinGroupRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'GroupRelatedByUpdatedBy', 'GroupQuery');
	}

	/**
	 * Filter the query by a related UserGroup object
	 *
	 * @param     UserGroup $userGroup  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUserGroupRelatedByUserId($userGroup, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $userGroup->getUserId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserGroupRelatedByUserId relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinUserGroupRelatedByUserId($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('UserGroupRelatedByUserId');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    UserGroupQuery A secondary query class using the current class as primary query
	 */
	public function useUserGroupRelatedByUserIdQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinUserGroupRelatedByUserId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserGroupRelatedByUserId', 'UserGroupQuery');
	}

	/**
	 * Filter the query by a related UserGroup object
	 *
	 * @param     UserGroup $userGroup  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUserGroupRelatedByCreatedBy($userGroup, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $userGroup->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserGroupRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinUserGroupRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('UserGroupRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    UserGroupQuery A secondary query class using the current class as primary query
	 */
	public function useUserGroupRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinUserGroupRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserGroupRelatedByCreatedBy', 'UserGroupQuery');
	}

	/**
	 * Filter the query by a related UserGroup object
	 *
	 * @param     UserGroup $userGroup  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUserGroupRelatedByUpdatedBy($userGroup, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $userGroup->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserGroupRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinUserGroupRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('UserGroupRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    UserGroupQuery A secondary query class using the current class as primary query
	 */
	public function useUserGroupRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinUserGroupRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserGroupRelatedByUpdatedBy', 'UserGroupQuery');
	}

	/**
	 * Filter the query by a related Right object
	 *
	 * @param     Right $right  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByRightRelatedByCreatedBy($right, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $right->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the RightRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinRightRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('RightRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    RightQuery A secondary query class using the current class as primary query
	 */
	public function useRightRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinRightRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'RightRelatedByCreatedBy', 'RightQuery');
	}

	/**
	 * Filter the query by a related Right object
	 *
	 * @param     Right $right  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByRightRelatedByUpdatedBy($right, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $right->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the RightRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinRightRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('RightRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    RightQuery A secondary query class using the current class as primary query
	 */
	public function useRightRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinRightRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'RightRelatedByUpdatedBy', 'RightQuery');
	}

	/**
	 * Filter the query by a related Document object
	 *
	 * @param     Document $document  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByDocumentRelatedByOwnerId($document, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $document->getOwnerId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the DocumentRelatedByOwnerId relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinDocumentRelatedByOwnerId($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('DocumentRelatedByOwnerId');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    DocumentQuery A secondary query class using the current class as primary query
	 */
	public function useDocumentRelatedByOwnerIdQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinDocumentRelatedByOwnerId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'DocumentRelatedByOwnerId', 'DocumentQuery');
	}

	/**
	 * Filter the query by a related Document object
	 *
	 * @param     Document $document  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByDocumentRelatedByCreatedBy($document, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $document->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the DocumentRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinDocumentRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('DocumentRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    DocumentQuery A secondary query class using the current class as primary query
	 */
	public function useDocumentRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinDocumentRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'DocumentRelatedByCreatedBy', 'DocumentQuery');
	}

	/**
	 * Filter the query by a related Document object
	 *
	 * @param     Document $document  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByDocumentRelatedByUpdatedBy($document, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $document->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the DocumentRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinDocumentRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('DocumentRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    DocumentQuery A secondary query class using the current class as primary query
	 */
	public function useDocumentRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinDocumentRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'DocumentRelatedByUpdatedBy', 'DocumentQuery');
	}

	/**
	 * Filter the query by a related DocumentType object
	 *
	 * @param     DocumentType $documentType  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByDocumentTypeRelatedByCreatedBy($documentType, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $documentType->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the DocumentTypeRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinDocumentTypeRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('DocumentTypeRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    DocumentTypeQuery A secondary query class using the current class as primary query
	 */
	public function useDocumentTypeRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinDocumentTypeRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'DocumentTypeRelatedByCreatedBy', 'DocumentTypeQuery');
	}

	/**
	 * Filter the query by a related DocumentType object
	 *
	 * @param     DocumentType $documentType  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByDocumentTypeRelatedByUpdatedBy($documentType, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $documentType->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the DocumentTypeRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinDocumentTypeRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('DocumentTypeRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    DocumentTypeQuery A secondary query class using the current class as primary query
	 */
	public function useDocumentTypeRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinDocumentTypeRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'DocumentTypeRelatedByUpdatedBy', 'DocumentTypeQuery');
	}

	/**
	 * Filter the query by a related DocumentCategory object
	 *
	 * @param     DocumentCategory $documentCategory  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByDocumentCategoryRelatedByCreatedBy($documentCategory, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $documentCategory->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the DocumentCategoryRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinDocumentCategoryRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('DocumentCategoryRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    DocumentCategoryQuery A secondary query class using the current class as primary query
	 */
	public function useDocumentCategoryRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinDocumentCategoryRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'DocumentCategoryRelatedByCreatedBy', 'DocumentCategoryQuery');
	}

	/**
	 * Filter the query by a related DocumentCategory object
	 *
	 * @param     DocumentCategory $documentCategory  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByDocumentCategoryRelatedByUpdatedBy($documentCategory, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $documentCategory->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the DocumentCategoryRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinDocumentCategoryRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('DocumentCategoryRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    DocumentCategoryQuery A secondary query class using the current class as primary query
	 */
	public function useDocumentCategoryRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinDocumentCategoryRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'DocumentCategoryRelatedByUpdatedBy', 'DocumentCategoryQuery');
	}

	/**
	 * Filter the query by a related Tag object
	 *
	 * @param     Tag $tag  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByTagRelatedByCreatedBy($tag, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $tag->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the TagRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinTagRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('TagRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    TagQuery A secondary query class using the current class as primary query
	 */
	public function useTagRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinTagRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'TagRelatedByCreatedBy', 'TagQuery');
	}

	/**
	 * Filter the query by a related Tag object
	 *
	 * @param     Tag $tag  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByTagRelatedByUpdatedBy($tag, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $tag->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the TagRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinTagRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('TagRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    TagQuery A secondary query class using the current class as primary query
	 */
	public function useTagRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinTagRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'TagRelatedByUpdatedBy', 'TagQuery');
	}

	/**
	 * Filter the query by a related TagInstance object
	 *
	 * @param     TagInstance $tagInstance  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByTagInstanceRelatedByCreatedBy($tagInstance, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $tagInstance->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the TagInstanceRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinTagInstanceRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('TagInstanceRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    TagInstanceQuery A secondary query class using the current class as primary query
	 */
	public function useTagInstanceRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinTagInstanceRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'TagInstanceRelatedByCreatedBy', 'TagInstanceQuery');
	}

	/**
	 * Filter the query by a related TagInstance object
	 *
	 * @param     TagInstance $tagInstance  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByTagInstanceRelatedByUpdatedBy($tagInstance, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $tagInstance->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the TagInstanceRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinTagInstanceRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('TagInstanceRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    TagInstanceQuery A secondary query class using the current class as primary query
	 */
	public function useTagInstanceRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinTagInstanceRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'TagInstanceRelatedByUpdatedBy', 'TagInstanceQuery');
	}

	/**
	 * Filter the query by a related Link object
	 *
	 * @param     Link $link  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLinkRelatedByOwnerId($link, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $link->getOwnerId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LinkRelatedByOwnerId relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinLinkRelatedByOwnerId($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('LinkRelatedByOwnerId');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    LinkQuery A secondary query class using the current class as primary query
	 */
	public function useLinkRelatedByOwnerIdQuery($relationAlias = '', $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinLinkRelatedByOwnerId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'LinkRelatedByOwnerId', 'LinkQuery');
	}

	/**
	 * Filter the query by a related Link object
	 *
	 * @param     Link $link  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLinkRelatedByCreatedBy($link, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $link->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LinkRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinLinkRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('LinkRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    LinkQuery A secondary query class using the current class as primary query
	 */
	public function useLinkRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinLinkRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'LinkRelatedByCreatedBy', 'LinkQuery');
	}

	/**
	 * Filter the query by a related Link object
	 *
	 * @param     Link $link  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLinkRelatedByUpdatedBy($link, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $link->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LinkRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinLinkRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('LinkRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    LinkQuery A secondary query class using the current class as primary query
	 */
	public function useLinkRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinLinkRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'LinkRelatedByUpdatedBy', 'LinkQuery');
	}

	/**
	 * Filter the query by a related LinkCategory object
	 *
	 * @param     LinkCategory $linkCategory  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLinkCategoryRelatedByCreatedBy($linkCategory, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $linkCategory->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LinkCategoryRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinLinkCategoryRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('LinkCategoryRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    LinkCategoryQuery A secondary query class using the current class as primary query
	 */
	public function useLinkCategoryRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinLinkCategoryRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'LinkCategoryRelatedByCreatedBy', 'LinkCategoryQuery');
	}

	/**
	 * Filter the query by a related LinkCategory object
	 *
	 * @param     LinkCategory $linkCategory  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLinkCategoryRelatedByUpdatedBy($linkCategory, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $linkCategory->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LinkCategoryRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinLinkCategoryRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('LinkCategoryRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    LinkCategoryQuery A secondary query class using the current class as primary query
	 */
	public function useLinkCategoryRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinLinkCategoryRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'LinkCategoryRelatedByUpdatedBy', 'LinkCategoryQuery');
	}

	/**
	 * Filter the query by a related Reference object
	 *
	 * @param     Reference $reference  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByReferenceRelatedByCreatedBy($reference, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $reference->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the ReferenceRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinReferenceRelatedByCreatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('ReferenceRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    ReferenceQuery A secondary query class using the current class as primary query
	 */
	public function useReferenceRelatedByCreatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinReferenceRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'ReferenceRelatedByCreatedBy', 'ReferenceQuery');
	}

	/**
	 * Filter the query by a related Reference object
	 *
	 * @param     Reference $reference  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByReferenceRelatedByUpdatedBy($reference, $comparison = Criteria::EQUAL)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $reference->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the ReferenceRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinReferenceRelatedByUpdatedBy($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('ReferenceRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		
		// add the ModelJoin to the current object
		if($relationAlias) {
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
	 * @return    ReferenceQuery A secondary query class using the current class as primary query
	 */
	public function useReferenceRelatedByUpdatedByQuery($relationAlias = '', $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinReferenceRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'ReferenceRelatedByUpdatedBy', 'ReferenceQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     User $user Object to remove from the list of results
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function prune($user = null)
	{
		if ($user) {
			$this->addUsingAlias(UserPeer::ID, $user->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

	/**
	 * Code to execute before every SELECT statement
	 * 
	 * @param     PropelPDO $con The connection object used by the query
	 */
	protected function basePreSelect(PropelPDO $con)
	{
		return $this->preSelect($con);
	}

	/**
	 * Code to execute before every DELETE statement
	 * 
	 * @param     PropelPDO $con The connection object used by the query
	 */
	protected function basePreDelete(PropelPDO $con)
	{
		return $this->preDelete($con);
	}

	/**
	 * Code to execute before every UPDATE statement
	 * 
	 * @param     array $values The associatiove array of columns and values for the update
	 * @param     PropelPDO $con The connection object used by the query
	 */
	protected function basePreUpdate(&$values, PropelPDO $con)
	{
		return $this->preUpdate($values, $con);
	}

	// timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     UserQuery The current query, for fuid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(UserPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     UserQuery The current query, for fuid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(UserPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     UserQuery The current query, for fuid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(UserPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     UserQuery The current query, for fuid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(UserPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     UserQuery The current query, for fuid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(UserPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     UserQuery The current query, for fuid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(UserPeer::CREATED_AT);
	}

	// attributable behavior
	
} // BaseUserQuery
