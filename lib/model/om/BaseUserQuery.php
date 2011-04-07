<?php


/**
 * Base class that represents a query for the 'users' table.
 *
 * 
 *
 * @method     UserQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     UserQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     UserQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     UserQuery orderByDigestHA1($order = Criteria::ASC) Order by the digest_ha1 column
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
 * @method     UserQuery groupByDigestHA1() Group by the digest_ha1 column
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
 * @method     UserQuery leftJoinLanguageRelatedByLanguageId($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageRelatedByLanguageId relation
 * @method     UserQuery rightJoinLanguageRelatedByLanguageId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageRelatedByLanguageId relation
 * @method     UserQuery innerJoinLanguageRelatedByLanguageId($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageRelatedByLanguageId relation
 *
 * @method     UserQuery leftJoinPageRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageRelatedByCreatedBy relation
 * @method     UserQuery rightJoinPageRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageRelatedByCreatedBy relation
 * @method     UserQuery innerJoinPageRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PageRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinPageRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinPageRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinPageRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PageRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinPagePropertyRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PagePropertyRelatedByCreatedBy relation
 * @method     UserQuery rightJoinPagePropertyRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PagePropertyRelatedByCreatedBy relation
 * @method     UserQuery innerJoinPagePropertyRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PagePropertyRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinPagePropertyRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PagePropertyRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinPagePropertyRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PagePropertyRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinPagePropertyRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PagePropertyRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinPageStringRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageStringRelatedByCreatedBy relation
 * @method     UserQuery rightJoinPageStringRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageStringRelatedByCreatedBy relation
 * @method     UserQuery innerJoinPageStringRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PageStringRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinPageStringRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PageStringRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinPageStringRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PageStringRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinPageStringRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the PageStringRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinContentObjectRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentObjectRelatedByCreatedBy relation
 * @method     UserQuery rightJoinContentObjectRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentObjectRelatedByCreatedBy relation
 * @method     UserQuery innerJoinContentObjectRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentObjectRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinContentObjectRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContentObjectRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinContentObjectRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContentObjectRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinContentObjectRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the ContentObjectRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinLanguageObjectRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageObjectRelatedByCreatedBy relation
 * @method     UserQuery rightJoinLanguageObjectRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageObjectRelatedByCreatedBy relation
 * @method     UserQuery innerJoinLanguageObjectRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageObjectRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinLanguageObjectRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageObjectRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinLanguageObjectRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageObjectRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinLanguageObjectRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageObjectRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinLanguageObjectHistoryRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageObjectHistoryRelatedByCreatedBy relation
 * @method     UserQuery rightJoinLanguageObjectHistoryRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageObjectHistoryRelatedByCreatedBy relation
 * @method     UserQuery innerJoinLanguageObjectHistoryRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageObjectHistoryRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinLanguageObjectHistoryRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageObjectHistoryRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinLanguageObjectHistoryRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageObjectHistoryRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinLanguageObjectHistoryRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageObjectHistoryRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinLanguageRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageRelatedByCreatedBy relation
 * @method     UserQuery rightJoinLanguageRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageRelatedByCreatedBy relation
 * @method     UserQuery innerJoinLanguageRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinLanguageRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LanguageRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinLanguageRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LanguageRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinLanguageRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LanguageRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinStringRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the StringRelatedByCreatedBy relation
 * @method     UserQuery rightJoinStringRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StringRelatedByCreatedBy relation
 * @method     UserQuery innerJoinStringRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the StringRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinStringRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the StringRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinStringRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StringRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinStringRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the StringRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinUserGroupRelatedByUserId($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserGroupRelatedByUserId relation
 * @method     UserQuery rightJoinUserGroupRelatedByUserId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserGroupRelatedByUserId relation
 * @method     UserQuery innerJoinUserGroupRelatedByUserId($relationAlias = null) Adds a INNER JOIN clause to the query using the UserGroupRelatedByUserId relation
 *
 * @method     UserQuery leftJoinUserGroupRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserGroupRelatedByCreatedBy relation
 * @method     UserQuery rightJoinUserGroupRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserGroupRelatedByCreatedBy relation
 * @method     UserQuery innerJoinUserGroupRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserGroupRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinUserGroupRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserGroupRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinUserGroupRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserGroupRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinUserGroupRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserGroupRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinGroupRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupRelatedByCreatedBy relation
 * @method     UserQuery rightJoinGroupRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupRelatedByCreatedBy relation
 * @method     UserQuery innerJoinGroupRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinGroupRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinGroupRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinGroupRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinGroupRoleRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupRoleRelatedByCreatedBy relation
 * @method     UserQuery rightJoinGroupRoleRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupRoleRelatedByCreatedBy relation
 * @method     UserQuery innerJoinGroupRoleRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupRoleRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinGroupRoleRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupRoleRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinGroupRoleRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupRoleRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinGroupRoleRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupRoleRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinRoleRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the RoleRelatedByCreatedBy relation
 * @method     UserQuery rightJoinRoleRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RoleRelatedByCreatedBy relation
 * @method     UserQuery innerJoinRoleRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the RoleRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinRoleRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the RoleRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinRoleRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RoleRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinRoleRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the RoleRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinUserRoleRelatedByUserId($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRoleRelatedByUserId relation
 * @method     UserQuery rightJoinUserRoleRelatedByUserId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRoleRelatedByUserId relation
 * @method     UserQuery innerJoinUserRoleRelatedByUserId($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRoleRelatedByUserId relation
 *
 * @method     UserQuery leftJoinUserRoleRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRoleRelatedByCreatedBy relation
 * @method     UserQuery rightJoinUserRoleRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRoleRelatedByCreatedBy relation
 * @method     UserQuery innerJoinUserRoleRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRoleRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinUserRoleRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserRoleRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinUserRoleRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserRoleRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinUserRoleRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the UserRoleRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinRightRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the RightRelatedByCreatedBy relation
 * @method     UserQuery rightJoinRightRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RightRelatedByCreatedBy relation
 * @method     UserQuery innerJoinRightRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the RightRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinRightRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the RightRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinRightRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RightRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinRightRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the RightRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinDocumentRelatedByOwnerId($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentRelatedByOwnerId relation
 * @method     UserQuery rightJoinDocumentRelatedByOwnerId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentRelatedByOwnerId relation
 * @method     UserQuery innerJoinDocumentRelatedByOwnerId($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentRelatedByOwnerId relation
 *
 * @method     UserQuery leftJoinDocumentRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentRelatedByCreatedBy relation
 * @method     UserQuery rightJoinDocumentRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentRelatedByCreatedBy relation
 * @method     UserQuery innerJoinDocumentRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinDocumentRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinDocumentRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinDocumentRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinDocumentTypeRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentTypeRelatedByCreatedBy relation
 * @method     UserQuery rightJoinDocumentTypeRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentTypeRelatedByCreatedBy relation
 * @method     UserQuery innerJoinDocumentTypeRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentTypeRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinDocumentTypeRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentTypeRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinDocumentTypeRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentTypeRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinDocumentTypeRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentTypeRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinDocumentCategoryRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentCategoryRelatedByCreatedBy relation
 * @method     UserQuery rightJoinDocumentCategoryRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentCategoryRelatedByCreatedBy relation
 * @method     UserQuery innerJoinDocumentCategoryRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentCategoryRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinDocumentCategoryRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentCategoryRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinDocumentCategoryRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentCategoryRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinDocumentCategoryRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentCategoryRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinTagRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TagRelatedByCreatedBy relation
 * @method     UserQuery rightJoinTagRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TagRelatedByCreatedBy relation
 * @method     UserQuery innerJoinTagRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TagRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinTagRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TagRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinTagRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TagRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinTagRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TagRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinTagInstanceRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TagInstanceRelatedByCreatedBy relation
 * @method     UserQuery rightJoinTagInstanceRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TagInstanceRelatedByCreatedBy relation
 * @method     UserQuery innerJoinTagInstanceRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TagInstanceRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinTagInstanceRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TagInstanceRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinTagInstanceRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TagInstanceRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinTagInstanceRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TagInstanceRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinLinkRelatedByOwnerId($relationAlias = null) Adds a LEFT JOIN clause to the query using the LinkRelatedByOwnerId relation
 * @method     UserQuery rightJoinLinkRelatedByOwnerId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LinkRelatedByOwnerId relation
 * @method     UserQuery innerJoinLinkRelatedByOwnerId($relationAlias = null) Adds a INNER JOIN clause to the query using the LinkRelatedByOwnerId relation
 *
 * @method     UserQuery leftJoinLinkRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LinkRelatedByCreatedBy relation
 * @method     UserQuery rightJoinLinkRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LinkRelatedByCreatedBy relation
 * @method     UserQuery innerJoinLinkRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LinkRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinLinkRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LinkRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinLinkRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LinkRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinLinkRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LinkRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinLinkCategoryRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LinkCategoryRelatedByCreatedBy relation
 * @method     UserQuery rightJoinLinkCategoryRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LinkCategoryRelatedByCreatedBy relation
 * @method     UserQuery innerJoinLinkCategoryRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LinkCategoryRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinLinkCategoryRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the LinkCategoryRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinLinkCategoryRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the LinkCategoryRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinLinkCategoryRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the LinkCategoryRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinReferenceRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the ReferenceRelatedByCreatedBy relation
 * @method     UserQuery rightJoinReferenceRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ReferenceRelatedByCreatedBy relation
 * @method     UserQuery innerJoinReferenceRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the ReferenceRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinReferenceRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the ReferenceRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinReferenceRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ReferenceRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinReferenceRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the ReferenceRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinNewsletterRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the NewsletterRelatedByCreatedBy relation
 * @method     UserQuery rightJoinNewsletterRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the NewsletterRelatedByCreatedBy relation
 * @method     UserQuery innerJoinNewsletterRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the NewsletterRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinNewsletterRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the NewsletterRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinNewsletterRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the NewsletterRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinNewsletterRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the NewsletterRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinNewsletterMailing($relationAlias = null) Adds a LEFT JOIN clause to the query using the NewsletterMailing relation
 * @method     UserQuery rightJoinNewsletterMailing($relationAlias = null) Adds a RIGHT JOIN clause to the query using the NewsletterMailing relation
 * @method     UserQuery innerJoinNewsletterMailing($relationAlias = null) Adds a INNER JOIN clause to the query using the NewsletterMailing relation
 *
 * @method     UserQuery leftJoinSubscriberRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the SubscriberRelatedByCreatedBy relation
 * @method     UserQuery rightJoinSubscriberRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SubscriberRelatedByCreatedBy relation
 * @method     UserQuery innerJoinSubscriberRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the SubscriberRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinSubscriberRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the SubscriberRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinSubscriberRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SubscriberRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinSubscriberRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the SubscriberRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinSubscriberGroupMembershipRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the SubscriberGroupMembershipRelatedByCreatedBy relation
 * @method     UserQuery rightJoinSubscriberGroupMembershipRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SubscriberGroupMembershipRelatedByCreatedBy relation
 * @method     UserQuery innerJoinSubscriberGroupMembershipRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the SubscriberGroupMembershipRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinSubscriberGroupMembershipRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the SubscriberGroupMembershipRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinSubscriberGroupMembershipRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SubscriberGroupMembershipRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinSubscriberGroupMembershipRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the SubscriberGroupMembershipRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinSubscriberGroupRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the SubscriberGroupRelatedByCreatedBy relation
 * @method     UserQuery rightJoinSubscriberGroupRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SubscriberGroupRelatedByCreatedBy relation
 * @method     UserQuery innerJoinSubscriberGroupRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the SubscriberGroupRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinSubscriberGroupRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the SubscriberGroupRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinSubscriberGroupRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SubscriberGroupRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinSubscriberGroupRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the SubscriberGroupRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinTipStringRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TipStringRelatedByCreatedBy relation
 * @method     UserQuery rightJoinTipStringRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TipStringRelatedByCreatedBy relation
 * @method     UserQuery innerJoinTipStringRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TipStringRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinTipStringRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TipStringRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinTipStringRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TipStringRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinTipStringRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TipStringRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinTipRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TipRelatedByCreatedBy relation
 * @method     UserQuery rightJoinTipRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TipRelatedByCreatedBy relation
 * @method     UserQuery innerJoinTipRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TipRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinTipRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TipRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinTipRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TipRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinTipRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TipRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinTipCategoryRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TipCategoryRelatedByCreatedBy relation
 * @method     UserQuery rightJoinTipCategoryRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TipCategoryRelatedByCreatedBy relation
 * @method     UserQuery innerJoinTipCategoryRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TipCategoryRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinTipCategoryRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the TipCategoryRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinTipCategoryRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TipCategoryRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinTipCategoryRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the TipCategoryRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinFrontendUserRelatedByUserId($relationAlias = null) Adds a LEFT JOIN clause to the query using the FrontendUserRelatedByUserId relation
 * @method     UserQuery rightJoinFrontendUserRelatedByUserId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FrontendUserRelatedByUserId relation
 * @method     UserQuery innerJoinFrontendUserRelatedByUserId($relationAlias = null) Adds a INNER JOIN clause to the query using the FrontendUserRelatedByUserId relation
 *
 * @method     UserQuery leftJoinFrontendUserRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the FrontendUserRelatedByCreatedBy relation
 * @method     UserQuery rightJoinFrontendUserRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FrontendUserRelatedByCreatedBy relation
 * @method     UserQuery innerJoinFrontendUserRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the FrontendUserRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinFrontendUserRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the FrontendUserRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinFrontendUserRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FrontendUserRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinFrontendUserRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the FrontendUserRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinScoreRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the ScoreRelatedByCreatedBy relation
 * @method     UserQuery rightJoinScoreRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ScoreRelatedByCreatedBy relation
 * @method     UserQuery innerJoinScoreRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the ScoreRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinScoreRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the ScoreRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinScoreRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ScoreRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinScoreRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the ScoreRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinGameRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the GameRelatedByCreatedBy relation
 * @method     UserQuery rightJoinGameRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GameRelatedByCreatedBy relation
 * @method     UserQuery innerJoinGameRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the GameRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinGameRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the GameRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinGameRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GameRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinGameRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the GameRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinEpisodeRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the EpisodeRelatedByCreatedBy relation
 * @method     UserQuery rightJoinEpisodeRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EpisodeRelatedByCreatedBy relation
 * @method     UserQuery innerJoinEpisodeRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the EpisodeRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinEpisodeRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the EpisodeRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinEpisodeRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EpisodeRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinEpisodeRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the EpisodeRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinEpisodeTypeRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the EpisodeTypeRelatedByCreatedBy relation
 * @method     UserQuery rightJoinEpisodeTypeRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EpisodeTypeRelatedByCreatedBy relation
 * @method     UserQuery innerJoinEpisodeTypeRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the EpisodeTypeRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinEpisodeTypeRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the EpisodeTypeRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinEpisodeTypeRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the EpisodeTypeRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinEpisodeTypeRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the EpisodeTypeRelatedByUpdatedBy relation
 *
 * @method     UserQuery leftJoinCommentRelatedByCreatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the CommentRelatedByCreatedBy relation
 * @method     UserQuery rightJoinCommentRelatedByCreatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CommentRelatedByCreatedBy relation
 * @method     UserQuery innerJoinCommentRelatedByCreatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the CommentRelatedByCreatedBy relation
 *
 * @method     UserQuery leftJoinCommentRelatedByUpdatedBy($relationAlias = null) Adds a LEFT JOIN clause to the query using the CommentRelatedByUpdatedBy relation
 * @method     UserQuery rightJoinCommentRelatedByUpdatedBy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CommentRelatedByUpdatedBy relation
 * @method     UserQuery innerJoinCommentRelatedByUpdatedBy($relationAlias = null) Adds a INNER JOIN clause to the query using the CommentRelatedByUpdatedBy relation
 *
 * @method     User findOne(PropelPDO $con = null) Return the first User matching the query
 * @method     User findOneOrCreate(PropelPDO $con = null) Return the first User matching the query, or a new User object populated from the query conditions when no match is found
 *
 * @method     User findOneById(int $id) Return the first User filtered by the id column
 * @method     User findOneByUsername(string $username) Return the first User filtered by the username column
 * @method     User findOneByPassword(string $password) Return the first User filtered by the password column
 * @method     User findOneByDigestHA1(string $digest_ha1) Return the first User filtered by the digest_ha1 column
 * @method     User findOneByFirstName(string $first_name) Return the first User filtered by the first_name column
 * @method     User findOneByLastName(string $last_name) Return the first User filtered by the last_name column
 * @method     User findOneByEmail(string $email) Return the first User filtered by the email column
 * @method     User findOneByLanguageId(string $language_id) Return the first User filtered by the language_id column
 * @method     User findOneByIsAdmin(boolean $is_admin) Return the first User filtered by the is_admin column
 * @method     User findOneByIsBackendLoginEnabled(boolean $is_backend_login_enabled) Return the first User filtered by the is_backend_login_enabled column
 * @method     User findOneByIsInactive(boolean $is_inactive) Return the first User filtered by the is_inactive column
 * @method     User findOneByPasswordRecoverHint(string $password_recover_hint) Return the first User filtered by the password_recover_hint column
 * @method     User findOneByBackendSettings(resource $backend_settings) Return the first User filtered by the backend_settings column
 * @method     User findOneByCreatedAt(string $created_at) Return the first User filtered by the created_at column
 * @method     User findOneByUpdatedAt(string $updated_at) Return the first User filtered by the updated_at column
 * @method     User findOneByCreatedBy(int $created_by) Return the first User filtered by the created_by column
 * @method     User findOneByUpdatedBy(int $updated_by) Return the first User filtered by the updated_by column
 *
 * @method     array findById(int $id) Return User objects filtered by the id column
 * @method     array findByUsername(string $username) Return User objects filtered by the username column
 * @method     array findByPassword(string $password) Return User objects filtered by the password column
 * @method     array findByDigestHA1(string $digest_ha1) Return User objects filtered by the digest_ha1 column
 * @method     array findByFirstName(string $first_name) Return User objects filtered by the first_name column
 * @method     array findByLastName(string $last_name) Return User objects filtered by the last_name column
 * @method     array findByEmail(string $email) Return User objects filtered by the email column
 * @method     array findByLanguageId(string $language_id) Return User objects filtered by the language_id column
 * @method     array findByIsAdmin(boolean $is_admin) Return User objects filtered by the is_admin column
 * @method     array findByIsBackendLoginEnabled(boolean $is_backend_login_enabled) Return User objects filtered by the is_backend_login_enabled column
 * @method     array findByIsInactive(boolean $is_inactive) Return User objects filtered by the is_inactive column
 * @method     array findByPasswordRecoverHint(string $password_recover_hint) Return User objects filtered by the password_recover_hint column
 * @method     array findByBackendSettings(resource $backend_settings) Return User objects filtered by the backend_settings column
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
			$criteria = $this->isKeepQuery() ? clone $this : $this;
			$stmt = $criteria
				->filterByPrimaryKey($key)
				->getSelectStatement($con);
			return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
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
		$criteria = $this->isKeepQuery() ? clone $this : $this;
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
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
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
	 * @param     string $password The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
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
	 * @param     string $digestHA1 The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
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
	 * @param     string $firstName The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
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
	 * @param     string $lastName The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
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
	 * @param     string $email The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
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
	 * @param     string $languageId The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
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
	 * @param     boolean|string $isAdmin The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByIsAdmin($isAdmin = null, $comparison = null)
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
	public function filterByIsBackendLoginEnabled($isBackendLoginEnabled = null, $comparison = null)
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
	public function filterByIsInactive($isInactive = null, $comparison = null)
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
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByBackendSettings($backendSettings = null, $comparison = null)
	{
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
	 * @param     string|array $updatedAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
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
	 * @param     int|array $createdBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
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
	 * @param     int|array $updatedBy The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
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
	 * @param     Language $language  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLanguageRelatedByLanguageId($language, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::LANGUAGE_ID, $language->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the LanguageRelatedByLanguageId relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
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
		if($relationAlias) {
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
	 * @return    LanguageQuery A secondary query class using the current class as primary query
	 */
	public function useLanguageRelatedByLanguageIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinLanguageRelatedByLanguageId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'LanguageRelatedByLanguageId', 'LanguageQuery');
	}

	/**
	 * Filter the query by a related Page object
	 *
	 * @param     Page $page  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPageRelatedByCreatedBy($page, $comparison = null)
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
	public function usePageRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByPageRelatedByUpdatedBy($page, $comparison = null)
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
	public function usePageRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByPagePropertyRelatedByCreatedBy($pageProperty, $comparison = null)
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
	public function usePagePropertyRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByPagePropertyRelatedByUpdatedBy($pageProperty, $comparison = null)
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
	public function usePagePropertyRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByPageStringRelatedByCreatedBy($pageString, $comparison = null)
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
	public function usePageStringRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByPageStringRelatedByUpdatedBy($pageString, $comparison = null)
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
	public function usePageStringRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByContentObjectRelatedByCreatedBy($contentObject, $comparison = null)
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
	public function useContentObjectRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByContentObjectRelatedByUpdatedBy($contentObject, $comparison = null)
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
	public function useContentObjectRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByLanguageObjectRelatedByCreatedBy($languageObject, $comparison = null)
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
	public function useLanguageObjectRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByLanguageObjectRelatedByUpdatedBy($languageObject, $comparison = null)
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
	public function useLanguageObjectRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByLanguageObjectHistoryRelatedByCreatedBy($languageObjectHistory, $comparison = null)
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
	public function useLanguageObjectHistoryRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByLanguageObjectHistoryRelatedByUpdatedBy($languageObjectHistory, $comparison = null)
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
	public function useLanguageObjectHistoryRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByLanguageRelatedByCreatedBy($language, $comparison = null)
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
	public function useLanguageRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByLanguageRelatedByUpdatedBy($language, $comparison = null)
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
	public function useLanguageRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByStringRelatedByCreatedBy($string, $comparison = null)
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
	public function useStringRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByStringRelatedByUpdatedBy($string, $comparison = null)
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
	public function useStringRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinStringRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'StringRelatedByUpdatedBy', 'StringQuery');
	}

	/**
	 * Filter the query by a related UserGroup object
	 *
	 * @param     UserGroup $userGroup  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUserGroupRelatedByUserId($userGroup, $comparison = null)
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
	public function useUserGroupRelatedByUserIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
	public function filterByUserGroupRelatedByCreatedBy($userGroup, $comparison = null)
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
	public function useUserGroupRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByUserGroupRelatedByUpdatedBy($userGroup, $comparison = null)
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
	public function useUserGroupRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinUserGroupRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserGroupRelatedByUpdatedBy', 'UserGroupQuery');
	}

	/**
	 * Filter the query by a related Group object
	 *
	 * @param     Group $group  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByGroupRelatedByCreatedBy($group, $comparison = null)
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
	public function useGroupRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByGroupRelatedByUpdatedBy($group, $comparison = null)
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
	public function useGroupRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinGroupRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'GroupRelatedByUpdatedBy', 'GroupQuery');
	}

	/**
	 * Filter the query by a related GroupRole object
	 *
	 * @param     GroupRole $groupRole  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByGroupRoleRelatedByCreatedBy($groupRole, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $groupRole->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the GroupRoleRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
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
		if($relationAlias) {
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
	 * @return    GroupRoleQuery A secondary query class using the current class as primary query
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
	 * @param     GroupRole $groupRole  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByGroupRoleRelatedByUpdatedBy($groupRole, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $groupRole->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the GroupRoleRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
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
		if($relationAlias) {
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
	 * @return    GroupRoleQuery A secondary query class using the current class as primary query
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
	 * @param     Role $role  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByRoleRelatedByCreatedBy($role, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $role->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the RoleRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
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
		if($relationAlias) {
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
	 * @return    RoleQuery A secondary query class using the current class as primary query
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
	 * @param     Role $role  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByRoleRelatedByUpdatedBy($role, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $role->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the RoleRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
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
		if($relationAlias) {
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
	 * @return    RoleQuery A secondary query class using the current class as primary query
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
	 * @param     UserRole $userRole  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUserRoleRelatedByUserId($userRole, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $userRole->getUserId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRoleRelatedByUserId relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
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
		if($relationAlias) {
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
	 * @return    UserRoleQuery A secondary query class using the current class as primary query
	 */
	public function useUserRoleRelatedByUserIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinUserRoleRelatedByUserId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'UserRoleRelatedByUserId', 'UserRoleQuery');
	}

	/**
	 * Filter the query by a related UserRole object
	 *
	 * @param     UserRole $userRole  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUserRoleRelatedByCreatedBy($userRole, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $userRole->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRoleRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
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
		if($relationAlias) {
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
	 * @return    UserRoleQuery A secondary query class using the current class as primary query
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
	 * @param     UserRole $userRole  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUserRoleRelatedByUpdatedBy($userRole, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $userRole->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the UserRoleRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
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
		if($relationAlias) {
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
	 * @return    UserRoleQuery A secondary query class using the current class as primary query
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
	 * @param     Right $right  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByRightRelatedByCreatedBy($right, $comparison = null)
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
	public function useRightRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByRightRelatedByUpdatedBy($right, $comparison = null)
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
	public function useRightRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByDocumentRelatedByOwnerId($document, $comparison = null)
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
	public function useDocumentRelatedByOwnerIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
	public function filterByDocumentRelatedByCreatedBy($document, $comparison = null)
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
	public function useDocumentRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByDocumentRelatedByUpdatedBy($document, $comparison = null)
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
	public function useDocumentRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByDocumentTypeRelatedByCreatedBy($documentType, $comparison = null)
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
	public function useDocumentTypeRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByDocumentTypeRelatedByUpdatedBy($documentType, $comparison = null)
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
	public function useDocumentTypeRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByDocumentCategoryRelatedByCreatedBy($documentCategory, $comparison = null)
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
	public function useDocumentCategoryRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByDocumentCategoryRelatedByUpdatedBy($documentCategory, $comparison = null)
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
	public function useDocumentCategoryRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByTagRelatedByCreatedBy($tag, $comparison = null)
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
	public function useTagRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByTagRelatedByUpdatedBy($tag, $comparison = null)
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
	public function useTagRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByTagInstanceRelatedByCreatedBy($tagInstance, $comparison = null)
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
	public function useTagInstanceRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByTagInstanceRelatedByUpdatedBy($tagInstance, $comparison = null)
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
	public function useTagInstanceRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByLinkRelatedByOwnerId($link, $comparison = null)
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
	public function useLinkRelatedByOwnerIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
	public function filterByLinkRelatedByCreatedBy($link, $comparison = null)
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
	public function useLinkRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByLinkRelatedByUpdatedBy($link, $comparison = null)
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
	public function useLinkRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByLinkCategoryRelatedByCreatedBy($linkCategory, $comparison = null)
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
	public function useLinkCategoryRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByLinkCategoryRelatedByUpdatedBy($linkCategory, $comparison = null)
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
	public function useLinkCategoryRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByReferenceRelatedByCreatedBy($reference, $comparison = null)
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
	public function useReferenceRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
	public function filterByReferenceRelatedByUpdatedBy($reference, $comparison = null)
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
	public function useReferenceRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinReferenceRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'ReferenceRelatedByUpdatedBy', 'ReferenceQuery');
	}

	/**
	 * Filter the query by a related Newsletter object
	 *
	 * @param     Newsletter $newsletter  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByNewsletterRelatedByCreatedBy($newsletter, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $newsletter->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the NewsletterRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinNewsletterRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('NewsletterRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'NewsletterRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the NewsletterRelatedByCreatedBy relation Newsletter object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    NewsletterQuery A secondary query class using the current class as primary query
	 */
	public function useNewsletterRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinNewsletterRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'NewsletterRelatedByCreatedBy', 'NewsletterQuery');
	}

	/**
	 * Filter the query by a related Newsletter object
	 *
	 * @param     Newsletter $newsletter  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByNewsletterRelatedByUpdatedBy($newsletter, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $newsletter->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the NewsletterRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinNewsletterRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('NewsletterRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'NewsletterRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the NewsletterRelatedByUpdatedBy relation Newsletter object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    NewsletterQuery A secondary query class using the current class as primary query
	 */
	public function useNewsletterRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinNewsletterRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'NewsletterRelatedByUpdatedBy', 'NewsletterQuery');
	}

	/**
	 * Filter the query by a related NewsletterMailing object
	 *
	 * @param     NewsletterMailing $newsletterMailing  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByNewsletterMailing($newsletterMailing, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $newsletterMailing->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the NewsletterMailing relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinNewsletterMailing($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('NewsletterMailing');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'NewsletterMailing');
		}
		
		return $this;
	}

	/**
	 * Use the NewsletterMailing relation NewsletterMailing object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    NewsletterMailingQuery A secondary query class using the current class as primary query
	 */
	public function useNewsletterMailingQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinNewsletterMailing($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'NewsletterMailing', 'NewsletterMailingQuery');
	}

	/**
	 * Filter the query by a related Subscriber object
	 *
	 * @param     Subscriber $subscriber  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterBySubscriberRelatedByCreatedBy($subscriber, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $subscriber->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the SubscriberRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinSubscriberRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('SubscriberRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'SubscriberRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the SubscriberRelatedByCreatedBy relation Subscriber object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SubscriberQuery A secondary query class using the current class as primary query
	 */
	public function useSubscriberRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinSubscriberRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'SubscriberRelatedByCreatedBy', 'SubscriberQuery');
	}

	/**
	 * Filter the query by a related Subscriber object
	 *
	 * @param     Subscriber $subscriber  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterBySubscriberRelatedByUpdatedBy($subscriber, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $subscriber->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the SubscriberRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinSubscriberRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('SubscriberRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'SubscriberRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the SubscriberRelatedByUpdatedBy relation Subscriber object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SubscriberQuery A secondary query class using the current class as primary query
	 */
	public function useSubscriberRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinSubscriberRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'SubscriberRelatedByUpdatedBy', 'SubscriberQuery');
	}

	/**
	 * Filter the query by a related SubscriberGroupMembership object
	 *
	 * @param     SubscriberGroupMembership $subscriberGroupMembership  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterBySubscriberGroupMembershipRelatedByCreatedBy($subscriberGroupMembership, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $subscriberGroupMembership->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the SubscriberGroupMembershipRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinSubscriberGroupMembershipRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('SubscriberGroupMembershipRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'SubscriberGroupMembershipRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the SubscriberGroupMembershipRelatedByCreatedBy relation SubscriberGroupMembership object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SubscriberGroupMembershipQuery A secondary query class using the current class as primary query
	 */
	public function useSubscriberGroupMembershipRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinSubscriberGroupMembershipRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'SubscriberGroupMembershipRelatedByCreatedBy', 'SubscriberGroupMembershipQuery');
	}

	/**
	 * Filter the query by a related SubscriberGroupMembership object
	 *
	 * @param     SubscriberGroupMembership $subscriberGroupMembership  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterBySubscriberGroupMembershipRelatedByUpdatedBy($subscriberGroupMembership, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $subscriberGroupMembership->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the SubscriberGroupMembershipRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinSubscriberGroupMembershipRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('SubscriberGroupMembershipRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'SubscriberGroupMembershipRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the SubscriberGroupMembershipRelatedByUpdatedBy relation SubscriberGroupMembership object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SubscriberGroupMembershipQuery A secondary query class using the current class as primary query
	 */
	public function useSubscriberGroupMembershipRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinSubscriberGroupMembershipRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'SubscriberGroupMembershipRelatedByUpdatedBy', 'SubscriberGroupMembershipQuery');
	}

	/**
	 * Filter the query by a related SubscriberGroup object
	 *
	 * @param     SubscriberGroup $subscriberGroup  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterBySubscriberGroupRelatedByCreatedBy($subscriberGroup, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $subscriberGroup->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the SubscriberGroupRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinSubscriberGroupRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('SubscriberGroupRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'SubscriberGroupRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the SubscriberGroupRelatedByCreatedBy relation SubscriberGroup object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SubscriberGroupQuery A secondary query class using the current class as primary query
	 */
	public function useSubscriberGroupRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinSubscriberGroupRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'SubscriberGroupRelatedByCreatedBy', 'SubscriberGroupQuery');
	}

	/**
	 * Filter the query by a related SubscriberGroup object
	 *
	 * @param     SubscriberGroup $subscriberGroup  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterBySubscriberGroupRelatedByUpdatedBy($subscriberGroup, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $subscriberGroup->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the SubscriberGroupRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinSubscriberGroupRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('SubscriberGroupRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'SubscriberGroupRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the SubscriberGroupRelatedByUpdatedBy relation SubscriberGroup object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    SubscriberGroupQuery A secondary query class using the current class as primary query
	 */
	public function useSubscriberGroupRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinSubscriberGroupRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'SubscriberGroupRelatedByUpdatedBy', 'SubscriberGroupQuery');
	}

	/**
	 * Filter the query by a related TipString object
	 *
	 * @param     TipString $tipString  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByTipStringRelatedByCreatedBy($tipString, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $tipString->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the TipStringRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinTipStringRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('TipStringRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'TipStringRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the TipStringRelatedByCreatedBy relation TipString object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    TipStringQuery A secondary query class using the current class as primary query
	 */
	public function useTipStringRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinTipStringRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'TipStringRelatedByCreatedBy', 'TipStringQuery');
	}

	/**
	 * Filter the query by a related TipString object
	 *
	 * @param     TipString $tipString  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByTipStringRelatedByUpdatedBy($tipString, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $tipString->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the TipStringRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinTipStringRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('TipStringRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'TipStringRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the TipStringRelatedByUpdatedBy relation TipString object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    TipStringQuery A secondary query class using the current class as primary query
	 */
	public function useTipStringRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinTipStringRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'TipStringRelatedByUpdatedBy', 'TipStringQuery');
	}

	/**
	 * Filter the query by a related Tip object
	 *
	 * @param     Tip $tip  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByTipRelatedByCreatedBy($tip, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $tip->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the TipRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinTipRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('TipRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'TipRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the TipRelatedByCreatedBy relation Tip object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    TipQuery A secondary query class using the current class as primary query
	 */
	public function useTipRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinTipRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'TipRelatedByCreatedBy', 'TipQuery');
	}

	/**
	 * Filter the query by a related Tip object
	 *
	 * @param     Tip $tip  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByTipRelatedByUpdatedBy($tip, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $tip->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the TipRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinTipRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('TipRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'TipRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the TipRelatedByUpdatedBy relation Tip object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    TipQuery A secondary query class using the current class as primary query
	 */
	public function useTipRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinTipRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'TipRelatedByUpdatedBy', 'TipQuery');
	}

	/**
	 * Filter the query by a related TipCategory object
	 *
	 * @param     TipCategory $tipCategory  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByTipCategoryRelatedByCreatedBy($tipCategory, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $tipCategory->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the TipCategoryRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinTipCategoryRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('TipCategoryRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'TipCategoryRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the TipCategoryRelatedByCreatedBy relation TipCategory object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    TipCategoryQuery A secondary query class using the current class as primary query
	 */
	public function useTipCategoryRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinTipCategoryRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'TipCategoryRelatedByCreatedBy', 'TipCategoryQuery');
	}

	/**
	 * Filter the query by a related TipCategory object
	 *
	 * @param     TipCategory $tipCategory  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByTipCategoryRelatedByUpdatedBy($tipCategory, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $tipCategory->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the TipCategoryRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinTipCategoryRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('TipCategoryRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'TipCategoryRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the TipCategoryRelatedByUpdatedBy relation TipCategory object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    TipCategoryQuery A secondary query class using the current class as primary query
	 */
	public function useTipCategoryRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinTipCategoryRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'TipCategoryRelatedByUpdatedBy', 'TipCategoryQuery');
	}

	/**
	 * Filter the query by a related FrontendUser object
	 *
	 * @param     FrontendUser $frontendUser  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByFrontendUserRelatedByUserId($frontendUser, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $frontendUser->getUserId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the FrontendUserRelatedByUserId relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinFrontendUserRelatedByUserId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('FrontendUserRelatedByUserId');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'FrontendUserRelatedByUserId');
		}
		
		return $this;
	}

	/**
	 * Use the FrontendUserRelatedByUserId relation FrontendUser object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    FrontendUserQuery A secondary query class using the current class as primary query
	 */
	public function useFrontendUserRelatedByUserIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinFrontendUserRelatedByUserId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'FrontendUserRelatedByUserId', 'FrontendUserQuery');
	}

	/**
	 * Filter the query by a related FrontendUser object
	 *
	 * @param     FrontendUser $frontendUser  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByFrontendUserRelatedByCreatedBy($frontendUser, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $frontendUser->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the FrontendUserRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinFrontendUserRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('FrontendUserRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'FrontendUserRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the FrontendUserRelatedByCreatedBy relation FrontendUser object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    FrontendUserQuery A secondary query class using the current class as primary query
	 */
	public function useFrontendUserRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinFrontendUserRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'FrontendUserRelatedByCreatedBy', 'FrontendUserQuery');
	}

	/**
	 * Filter the query by a related FrontendUser object
	 *
	 * @param     FrontendUser $frontendUser  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByFrontendUserRelatedByUpdatedBy($frontendUser, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $frontendUser->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the FrontendUserRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinFrontendUserRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('FrontendUserRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'FrontendUserRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the FrontendUserRelatedByUpdatedBy relation FrontendUser object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    FrontendUserQuery A secondary query class using the current class as primary query
	 */
	public function useFrontendUserRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinFrontendUserRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'FrontendUserRelatedByUpdatedBy', 'FrontendUserQuery');
	}

	/**
	 * Filter the query by a related Score object
	 *
	 * @param     Score $score  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByScoreRelatedByCreatedBy($score, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $score->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the ScoreRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinScoreRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('ScoreRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'ScoreRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the ScoreRelatedByCreatedBy relation Score object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ScoreQuery A secondary query class using the current class as primary query
	 */
	public function useScoreRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinScoreRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'ScoreRelatedByCreatedBy', 'ScoreQuery');
	}

	/**
	 * Filter the query by a related Score object
	 *
	 * @param     Score $score  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByScoreRelatedByUpdatedBy($score, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $score->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the ScoreRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinScoreRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('ScoreRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'ScoreRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the ScoreRelatedByUpdatedBy relation Score object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    ScoreQuery A secondary query class using the current class as primary query
	 */
	public function useScoreRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinScoreRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'ScoreRelatedByUpdatedBy', 'ScoreQuery');
	}

	/**
	 * Filter the query by a related Game object
	 *
	 * @param     Game $game  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByGameRelatedByCreatedBy($game, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $game->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the GameRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinGameRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('GameRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'GameRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the GameRelatedByCreatedBy relation Game object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    GameQuery A secondary query class using the current class as primary query
	 */
	public function useGameRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinGameRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'GameRelatedByCreatedBy', 'GameQuery');
	}

	/**
	 * Filter the query by a related Game object
	 *
	 * @param     Game $game  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByGameRelatedByUpdatedBy($game, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $game->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the GameRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinGameRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('GameRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'GameRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the GameRelatedByUpdatedBy relation Game object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    GameQuery A secondary query class using the current class as primary query
	 */
	public function useGameRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinGameRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'GameRelatedByUpdatedBy', 'GameQuery');
	}

	/**
	 * Filter the query by a related Episode object
	 *
	 * @param     Episode $episode  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByEpisodeRelatedByCreatedBy($episode, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $episode->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the EpisodeRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinEpisodeRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('EpisodeRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'EpisodeRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the EpisodeRelatedByCreatedBy relation Episode object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    EpisodeQuery A secondary query class using the current class as primary query
	 */
	public function useEpisodeRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinEpisodeRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'EpisodeRelatedByCreatedBy', 'EpisodeQuery');
	}

	/**
	 * Filter the query by a related Episode object
	 *
	 * @param     Episode $episode  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByEpisodeRelatedByUpdatedBy($episode, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $episode->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the EpisodeRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinEpisodeRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('EpisodeRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'EpisodeRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the EpisodeRelatedByUpdatedBy relation Episode object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    EpisodeQuery A secondary query class using the current class as primary query
	 */
	public function useEpisodeRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinEpisodeRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'EpisodeRelatedByUpdatedBy', 'EpisodeQuery');
	}

	/**
	 * Filter the query by a related EpisodeType object
	 *
	 * @param     EpisodeType $episodeType  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByEpisodeTypeRelatedByCreatedBy($episodeType, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $episodeType->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the EpisodeTypeRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinEpisodeTypeRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('EpisodeTypeRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'EpisodeTypeRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the EpisodeTypeRelatedByCreatedBy relation EpisodeType object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    EpisodeTypeQuery A secondary query class using the current class as primary query
	 */
	public function useEpisodeTypeRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinEpisodeTypeRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'EpisodeTypeRelatedByCreatedBy', 'EpisodeTypeQuery');
	}

	/**
	 * Filter the query by a related EpisodeType object
	 *
	 * @param     EpisodeType $episodeType  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByEpisodeTypeRelatedByUpdatedBy($episodeType, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $episodeType->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the EpisodeTypeRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinEpisodeTypeRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('EpisodeTypeRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'EpisodeTypeRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the EpisodeTypeRelatedByUpdatedBy relation EpisodeType object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    EpisodeTypeQuery A secondary query class using the current class as primary query
	 */
	public function useEpisodeTypeRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinEpisodeTypeRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'EpisodeTypeRelatedByUpdatedBy', 'EpisodeTypeQuery');
	}

	/**
	 * Filter the query by a related Comment object
	 *
	 * @param     Comment $comment  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByCommentRelatedByCreatedBy($comment, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $comment->getCreatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the CommentRelatedByCreatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinCommentRelatedByCreatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('CommentRelatedByCreatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'CommentRelatedByCreatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the CommentRelatedByCreatedBy relation Comment object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    CommentQuery A secondary query class using the current class as primary query
	 */
	public function useCommentRelatedByCreatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinCommentRelatedByCreatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'CommentRelatedByCreatedBy', 'CommentQuery');
	}

	/**
	 * Filter the query by a related Comment object
	 *
	 * @param     Comment $comment  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByCommentRelatedByUpdatedBy($comment, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $comment->getUpdatedBy(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the CommentRelatedByUpdatedBy relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinCommentRelatedByUpdatedBy($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('CommentRelatedByUpdatedBy');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'CommentRelatedByUpdatedBy');
		}
		
		return $this;
	}

	/**
	 * Use the CommentRelatedByUpdatedBy relation Comment object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    CommentQuery A secondary query class using the current class as primary query
	 */
	public function useCommentRelatedByUpdatedByQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinCommentRelatedByUpdatedBy($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'CommentRelatedByUpdatedBy', 'CommentQuery');
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

	// extended_timestampable behavior
	
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

} // BaseUserQuery
